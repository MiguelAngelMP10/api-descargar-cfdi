<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MakeQueryPostRequest;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcOnBehalf;
use PhpCfdi\SatWsDescargaMasiva\Shared\Uuid;

class MakeQueryHelper extends Controller
{
    protected string $RFC;
    protected string $password;
    protected bool $retenciones;
    protected array $rfcMatch;
    protected DownloadType $downloadType;
    protected RequestType $requestType;
    protected DateTimePeriod $period;
    protected QueryParameters $queryParameters;

    /**
     * @param MakeQueryPostRequest $request
     *
     * @return void
     */
    protected function getParamsQuery(MakeQueryPostRequest $request)
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

    protected function addDocumentTypeToQueryParameters(MakeQueryPostRequest $request)
    {
        $documentType = $request->input('documentType');
        $this->queryParameters = $this->queryParameters
            ->withDocumentType($this->evaluateDocumentTypeMethod($documentType));
    }

    protected function evaluateDocumentTypeMethod(string $documentType): DocumentType
    {
        $documentTypeArray = [
            'I' => DocumentType::ingreso(),
            'E' => DocumentType::egreso(),
            'N' => DocumentType::nomina(),
            'T' => DocumentType::traslado(),
            'P' => DocumentType::pago(),
            '' => DocumentType::undefined(),
        ];

        return in_array($documentType, $documentTypeArray)
            ? $documentTypeArray[$documentType]
            : DocumentType::undefined();
    }

    protected function addDocumentStatus(MakeQueryPostRequest $request)
    {
        if ($request->has('documentStatus')) {
            if ($request->input('documentStatus') === 'active') {
                $documentStatusMethod = DocumentStatus::active();
            } elseif ($request->input('documentStatus') === 'cancelled') {
                $documentStatusMethod = DocumentStatus::cancelled();
            } else {
                $documentStatusMethod = DocumentStatus::undefined();
            }
            $this->queryParameters = $this->queryParameters->withDocumentStatus($documentStatusMethod);
        }
    }

    protected function addComplementoCfdi(MakeQueryPostRequest $request)
    {
        if ($request->has('complementoCfdi')) {
            $this->queryParameters =
                $this->queryParameters->withComplement((new ComplementoCfdi($request->input('complementoCfdi'))));
        }
    }

    protected function addUuid(MakeQueryPostRequest $request)
    {
        if ($request->has('uuid')) {
            $this->queryParameters =
                $this->queryParameters->withUuid(Uuid::create($request->input('uuid')));
        }
    }

    protected function addRfcOnBehalf(MakeQueryPostRequest $request)
    {
        if ($request->has('rfcOnBehalf')) {
            $this->queryParameters =
                $this->queryParameters->withRfcOnBehalf(RfcOnBehalf::create($request->input('rfcOnBehalf')));
        }
    }
}
