<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;

use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class VerifyQueryController extends Controller
{
    public function verifyQuery(Request $request)
    {
        $RFC =  $request->input('RFC');
        $password = $request->input('password');
        $retenciones = $request->boolean('retenciones');
        $requestId =  $request->input('requestId');


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


        // consultar el servicio de verificación
        $verify = $service->verify($requestId);

        // revisar que el proceso de verificación fue correcto
        if (!$verify->getStatus()->isAccepted()) {
            return response()->json([
                'message' => "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}"
            ]);
        }

        // revisar que la consulta no haya sido rechazada
        if (!$verify->getCodeRequest()->isAccepted()) {
            return response()->json([
                'message' => "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}"
            ]);
        }

        // revisar el progreso de la generación de los paquetes
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            return response()->json([
                'message' => "La solicitud {$requestId} no se puede completar"
            ]);
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            return response()->json([
                'message' => "La solicitud {$requestId} se está procesando"
            ]);
        }


        if ($statusRequest->isFinished()) {
            return response()->json([
                'message' => "La solicitud {$requestId} está lista",
                'numPaquetes' => "Se encontraron {$verify->countPackages()} paquetes",
                'packagesIds'  => $verify->getPackagesIds()
            ]);
        }
    }
}