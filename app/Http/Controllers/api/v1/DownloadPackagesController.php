<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpCfdi\SatWsDescargaMasiva\Service;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;

use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class DownloadPackagesController extends Controller
{
    public function downloadPackages(Request $request)
    {

        $password = $request->input('password');
        $RFC =  $request->input('RFC');
        $packagesIds = $request->input('packagesIds');
        $retenciones = $request->boolean('retenciones');


        $contentCer = Storage::get('datos/' . $RFC . "/" . $RFC . '.cer');
        $contentKey = Storage::get('datos/' . $RFC . "/" . $RFC . '.key');

        $fiel = Fiel::create(
            $contentCer,
            $contentKey,
            $password
        );

        // verificar que la FIEL sea válida (no sea CSD y sea vigente acorde a la fecha del sistema)
        if (!$fiel->isValid()) {
            return response()->json([
                'message' => 'La FIEL no es valida'
            ]);
        }

        // creación del web client basado en Guzzle que implementa WebClientInterface
        // para usarlo necesitas instalar guzzlehttp/guzzle pues no es una dependencia directa
        $webClient = new GuzzleWebClient();

        // creación del objeto encargado de crear las solicitudes firmadas usando una FIEL
        $requestBuilder = new FielRequestBuilder($fiel);

        // Creación del servicio
        if ($retenciones) {
            $service = new Service($requestBuilder, $webClient, null, ServiceEndpoints::retenciones());
        } else {
            $service = new Service($requestBuilder, $webClient);
        }

        /**
         * @var Service $service
         * @var string[] $packagesIds El listado de identificadores de paquetes generado en la (correcta) verificación
         */

        // consultar el servicio de verificación
        $messages = [];
        $errorMessages = [];
        foreach ($packagesIds as $packageId) {
            $download = $service->download($packageId);
            if (!$download->getStatus()->isAccepted()) {
                $errorMessages[] =  "El paquete {$packageId} no se ha podido descargar: {$download->getStatus()->getMessage()}";
                continue;
            }
            $zipfile = "$packageId.zip";
            file_put_contents($zipfile, $download->getPackageContent());
            $messages[] =  "El paquete {$packageId} se ha almacenado";
        }
        return response()->json(['errorMessages' => $errorMessages, 'messages' => $messages]);
    }
}
