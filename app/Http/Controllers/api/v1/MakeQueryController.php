<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;

use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;


use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;

class MakeQueryController extends Controller
{
    public function makeQuery(Request $request)
    {

        $RFC =  $request->input('RFC');
        $password = $request->input('password');
        $start = $request->input('period.start');
        $end = $request->input('period.end');
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
                'message' => 'La FIEL no es validad'
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


        // Realizar una consulta
        $period =  DateTimePeriod::createFromValues($start, $end);

        $downloadType = ($request->input('downloadType') === 'issued') ? DownloadType::issued() : DownloadType::received();
        $requestType = ($request->input('requestType') === 'cfdi') ? RequestType::cfdi() : RequestType::metadata();

        $rfcMatch = $request->input('rfcMatch') ?? "";

        $request = QueryParameters::create(
            $period,
            $downloadType,
            $requestType,
            $rfcMatch
        );

        // presentar la consulta
        $query =  $service->query($request);

        // verificar que el proceso de consulta fue correcto
        if (!$query->getStatus()->isAccepted()) {
            return response()->json([
                'message' => $query->getStatus()->getMessage(),
                'code' => $query->getStatus()
            ]);
        } else {
            return response()->json([
                'message' => $query->getStatus()->getMessage(),
                'code' => $query->getStatus(),
                'requestId' => $query->getRequestId()
            ]);
        }
    }
}