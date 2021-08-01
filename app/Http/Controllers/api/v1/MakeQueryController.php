<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

class MakeQueryController extends Controller
{
    public function makeQuery(Request $request)
    {
        $start = $request->input('period.start');
        $end = $request->input('period.end');

        // Realizar una consulta
        $period =  DateTimePeriod::createFromValues($start, $end);

        $downloadType = ($request->input('downloadType') === 'issued') ? DownloadType::issued() : DownloadType::received();
        $requestType = ($request->input('requestType') === 'cfdi') ? RequestType::cfdi() : RequestType::metadata();
        $rfcMatch = $request->input('rfcMatch') ?? "";

        $queryParameters = QueryParameters::create(
            $period,
            $downloadType,
            $requestType,
            $rfcMatch
        );

        $satWsServiceHelper = new SatWsService();
        try {
            $service = $satWsServiceHelper->createService(
                $request->input('RFC'),
                $request->input('password'),
                $request->boolean('retenciones')
            );
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        // presentar la consulta
        $query =  $service->query($queryParameters);

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
