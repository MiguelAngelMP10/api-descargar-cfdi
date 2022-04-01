<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakeQueryPostRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

class MakeQueryController extends Controller
{
    private DownloadType $downloadType;
    private RequestType $requestType;
    private string $rfcMatch;
    private DateTimePeriod $period;

    /**
     * @param MakeQueryPostRequest $request
     *
     * @return JsonResponse
     */

    public function makeQuery(MakeQueryPostRequest $request): JsonResponse
    {
        $this->getParamsQuery($request);
        $queryParameters = QueryParameters::create(
            $this->period,
            $this->downloadType,
            $this->requestType
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

        $query = $service->query($queryParameters);

        if (! $query->getStatus()->isAccepted()) {
            return response()->json($query->getStatus(), 400);
        }
        return response()->json([$query->getStatus(), 'requestId' => $query->getRequestId()], 200);
    }

    /**
     * @param MakeQueryPostRequest $request
     *
     * @return void
     */
    private function getParamsQuery(MakeQueryPostRequest $request)
    {
        $start = $request->input('period.start');
        $end = $request->input('period.end');

        $this->downloadType = $request->input('downloadType') === 'issued'
            ? DownloadType::issued() : DownloadType::received();

        $this->requestType = $request->input('requestType') === 'cfdi'
            ? RequestType::xml() : RequestType::metadata();

        $this->rfcMatch = $request->input('rfcMatch') ?? '';

        $this->period = DateTimePeriod::createFromValues($start, $end);
    }
}
