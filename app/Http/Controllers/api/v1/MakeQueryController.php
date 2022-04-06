<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakeQueryPostRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

class MakeQueryController extends Controller
{
    private string $RFC;
    private string $password;
    private bool $retenciones;
    private DownloadType $downloadType;
    private RequestType $requestType;
    private DateTimePeriod $period;
    private QueryParameters $queryParameters;

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

            if (!$query->getStatus()->isAccepted()) {
                return response()->json($query->getStatus(), 400);
            }

            return response()->json([$query->getStatus(), 'requestId' => $query->getRequestId()], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    /**
     * @param MakeQueryPostRequest $request
     *
     * @return void
     */
    private function getParamsQuery(MakeQueryPostRequest $request)
    {
        $this->RFC = $request->input('RFC');
        $this->password = $request->input('password');
        $this->retenciones = $request->boolean('retenciones');

        $start = $request->input('period.start');
        $end = $request->input('period.end');

        $this->downloadType = $request->input('downloadType') === 'issued'
            ? DownloadType::issued() : DownloadType::received();

        $this->requestType = $request->input('requestType') === 'xml'
            ? RequestType::xml() : RequestType::metadata();

        $this->rfcMatch = $request->input('rfcMatch') ?? [];

        $this->period = DateTimePeriod::createFromValues($start, $end);
    }

    private function addDocumentTypeToQueryParameters(MakeQueryPostRequest $request)
    {
        $documentType = $request->input('documentType');
        switch ($documentType) {
            case "ingreso":
            case "I":
                $this->queryParameters = $this->queryParameters->withDocumentType(DocumentType::ingreso());
                break;
            case "egreso":
            case "E":
                $this->queryParameters = $this->queryParameters->withDocumentType(DocumentType::egreso());
                break;
            case "traslado":
            case "T":
                $this->queryParameters = $this->queryParameters->withDocumentType(DocumentType::traslado());
                break;
            case "nomina":
            case "N":
                $this->queryParameters = $this->queryParameters->withDocumentType(DocumentType::nomina());
                break;
            case "pago":
            case "P":
                $this->queryParameters = $this->queryParameters->withDocumentType(DocumentType::pago());
                break;
            default:
                $this->queryParameters = $this->queryParameters->withDocumentType(DocumentType::undefined());
        }
    }

    private function addComplementoCfdi(MakeQueryPostRequest $request)
    {
        if ($request->has('complementoCfdi')) {
            $this->queryParameters =
                $this->queryParameters->withComplement((new ComplementoCfdi($request->input('complementoCfdi'))));
        }
    }

    private function addDocumentStatus(MakeQueryPostRequest $request)
    {
        if ($request->has('documentStatus')) {
            if ($request->input("documentStatus") === "active") {
                $this->queryParameters = $this->queryParameters->withDocumentStatus(DocumentStatus::active());
            }

            if ($request->input("documentStatus") === "cancelled") {
                $this->queryParameters = $this->queryParameters->withDocumentStatus(DocumentStatus::cancelled());
            }
        }
    }
}
