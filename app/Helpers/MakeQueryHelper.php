<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MakeQueryPostRequest;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

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

    protected function evaluateDocumentTypeMethod($documentType): DocumentType
    {
        switch ($documentType) {
            case 'I':
                return DocumentType::ingreso();
            case 'E':
                return DocumentType::egreso();
            case 'T':
                return DocumentType::traslado();
            case 'N':
                return DocumentType::nomina();
            case 'P':
                return DocumentType::pago();
            default:
                return DocumentType::undefined();
        }
    }

    protected function addComplementoCfdi(MakeQueryPostRequest $request)
    {
        if ($request->has('complementoCfdi')) {
            $this->queryParameters =
                $this->queryParameters->withComplement((new ComplementoCfdi($request->input('complementoCfdi'))));
        }
    }
}
