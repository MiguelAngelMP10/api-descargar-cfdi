<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1;

use App\Helpers\MakeQueryHelper;
use App\Helpers\SatWsService;
use App\Http\Requests\MakeQueryPostRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;

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

            $satWsServiceHelper = new SatWsService();
            $service = $satWsServiceHelper->createService(
                $this->RFC,
                $this->password,
                $this->retenciones
            );

            $query = $service->query($this->queryParameters);

            if (! $query->getStatus()->isAccepted()) {
                return response()->json($query->getStatus(), 400);
            }

            return response()->json([$query->getStatus(), 'requestId' => $query->getRequestId()], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    protected function addDocumentStatus(MakeQueryPostRequest $request)
    {
        if ($request->has('documentStatus')) {
            $documentStatusMethod = DocumentStatus::undefined();
            if ($request->input('documentStatus') === 'active') {
                $documentStatusMethod = DocumentStatus::active();
            }

            if ($request->input('documentStatus') === 'cancelled') {
                $documentStatusMethod = DocumentStatus::cancelled();
            }

            $this->queryParameters = $this->queryParameters->withDocumentStatus($documentStatusMethod);
        }
    }
}
