<?php

namespace App\Traits;

use App\Http\Requests\MakeQueryPostRequest;
use App\Http\Requests\StoreQueryRequest;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcMatches;
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcOnBehalf;
use PhpCfdi\SatWsDescargaMasiva\Shared\Uuid;

trait AddParametersToQuery
{
    protected function addDocumentTypeToQueryParameters(MakeQueryPostRequest|StoreQueryRequest $request): void
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

    protected function addDocumentStatus(MakeQueryPostRequest|StoreQueryRequest $request): void
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

    protected function addComplementoCfdi(MakeQueryPostRequest|StoreQueryRequest $request): void
    {
        if ($request->input('complementoCfdi') !== null) {
            $this->queryParameters =
                $this->queryParameters->withComplement((new ComplementoCfdi($request->input('complementoCfdi'))));
        }
    }

    protected function addUuid(MakeQueryPostRequest|StoreQueryRequest $request): void
    {
        if ($request->input('uuid') !== null) {
            $this->queryParameters =
                $this->queryParameters->withUuid(Uuid::create($request->input('uuid')));
        }
    }

    protected function addRfcOnBehalf(MakeQueryPostRequest|StoreQueryRequest $request): void
    {
        if ($request->input('rfcOnBehalf') !== null) {
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
