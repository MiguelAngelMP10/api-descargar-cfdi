<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1;

use App\Helpers\MakeQueryHelper;
use App\Helpers\SatWsService;
use App\Http\Requests\MakeQueryPostRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;

class MakeQueryController extends MakeQueryHelper
{
    /**
     * @param MakeQueryPostRequest $request
     *
     * @return JsonResponse
     */

    public function makeQuery(MakeQueryPostRequest $request): JsonResponse
    {
        try {
            $this->getParamsQuery($request);

            $this->queryParameters = QueryParameters::create()
                ->withPeriod($this->period)
                ->withDownloadType($this->downloadType)
                ->withRequestType($this->requestType);

            $this->addDocumentTypeToQueryParameters($request);
            $this->addComplementoCfdi($request);
            $this->addDocumentStatus($request);
            $this->addUuid($request);
            $this->addRfcOnBehalf($request);
            $this->addRfcMatches();

            $satWsServiceHelper = new SatWsService();
            $service = $satWsServiceHelper->createService(
                $this->cer,
                $this->key,
                $this->password,
                $this->endPoint
            );

            $query = $service->query($this->queryParameters);

            if (! $query->getStatus()->isAccepted()) {
                return response()->json($query->getStatus(), 400);
            }

            return response()->json(['Status' => $query->getStatus(), 'requestId' => $query->getRequestId()]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }
}
