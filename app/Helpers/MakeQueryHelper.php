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
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcMatches;
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcOnBehalf;
use PhpCfdi\SatWsDescargaMasiva\Shared\Uuid;

class MakeQueryHelper extends Controller
{
    protected string $cer;
    protected string $key;
    protected string $password;
    protected string|null $endPoint;
    protected array $rfcMatches;
    protected DownloadType $downloadType;
    protected RequestType $requestType;
    protected DateTimePeriod $period;
    protected QueryParameters $queryParameters;

    /**
     * @param MakeQueryPostRequest $request
     *
     * @return void
     */
    protected function getParamsQuery(MakeQueryPostRequest $request): void
    {
        $this->cer = $request->input('cer');
        $this->key = $request->input('key');
        $this->password = $request->input('password');
        $this->endPoint = $request->input('endPoint');

        $start = $request->input('period.start');
        $end = $request->input('period.end');

        $this->downloadType = $request->input('downloadType') === 'issued'
            ? DownloadType::issued() : DownloadType::received();

        $this->requestType = $request->input('requestType') === 'xml'
            ? RequestType::xml() : RequestType::metadata();

        $this->rfcMatches = $request->has('rfcMatches') ? $request->input('rfcMatches') : [];

        $this->period = DateTimePeriod::createFromValues($start, $end);
    }

    protected function addDocumentTypeToQueryParameters(MakeQueryPostRequest $request): void
    {
        if ($request->has('documentType')) {
            $documentType = $request->input('documentType');
            if (is_null($documentType)) {
                $this->queryParameters = $this->queryParameters
                    ->withDocumentType(DocumentType::undefined());
            } else {
                $this->queryParameters = $this->queryParameters
                    ->withDocumentType($this->evaluateDocumentTypeMethod($documentType));
            }
        } else {
            $this->queryParameters = $this->queryParameters
                ->withDocumentType(DocumentType::undefined());
        }
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

    protected function addDocumentStatus(MakeQueryPostRequest $request): void
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

    protected function addComplementoCfdi(MakeQueryPostRequest $request): void
    {
        if ($request->has('complementoCfdi')) {
            $this->queryParameters =
                $this->queryParameters->withComplement((new ComplementoCfdi($request->input('complementoCfdi'))));
        }
    }

    protected function addUuid(MakeQueryPostRequest $request): void
    {
        if ($request->has('uuid')) {
            $this->queryParameters =
                $this->queryParameters->withUuid(Uuid::create($request->input('uuid')));
        }
    }

    protected function addRfcOnBehalf(MakeQueryPostRequest $request): void
    {
        if ($request->has('rfcOnBehalf')) {
            $this->queryParameters =
                $this->queryParameters->withRfcOnBehalf(RfcOnBehalf::create($request->input('rfcOnBehalf')));
        }
    }

    protected function addRfcMatches(): void
    {
        $this->queryParameters = $this->queryParameters->withRfcMatches(
            RfcMatches::createFromValues(...$this->rfcMatches)
        );
    }
}
