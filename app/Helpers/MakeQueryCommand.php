<?php

namespace App\Helpers;

use App\Console\Traits\ValidateOptionsMakeQuery;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcMatches;
use PhpCfdi\SatWsDescargaMasiva\Shared\RfcOnBehalf;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
use PhpCfdi\SatWsDescargaMasiva\Shared\Uuid;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

class MakeQueryCommand extends Command
{
    use ValidateOptionsMakeQuery;

    protected QueryParameters $queryParameters;

    protected ServiceEndpoints $endpoints;

    protected Fiel $fiel;

    protected QueryResult $query;

    protected function presentQuery()
    {
        $webClient = new GuzzleWebClient();
        $requestBuilder = new FielRequestBuilder($this->fiel);
        $service = new Service($requestBuilder, $webClient, null, $this->endpoints);
        $this->query = $service->query($this->queryParameters);
        $this->tableResultQuery();
        $this->writeQueryResultFile();
    }

    protected function tableResultQuery()
    {
        $separator = new TableSeparator();
        $this->table(
            [new TableCell('Data Result Query', ['colspan' => 2])],
            [
                [new TableCell('Status', ['colspan' => 2])],
                $separator,
                ['Code', $this->query->getStatus()->getCode()],
                ['Message', $this->query->getStatus()->getMessage()],
                ['RequestId', $this->query->getRequestId()],
            ]
        );
    }

    protected function querySummary()
    {
        $separator = new TableSeparator();
        $this->table(
            [new TableCell('Query summary', ['colspan' => 2])],
            [
                ['Data', 'Value'],
                [new TableCell('Period', ['colspan' => 2])],
                $separator,
                ['Start', $this->queryParameters->getPeriod()->getStart()->formatDefaultTimeZone()],
                ['End', $this->queryParameters->getPeriod()->getEnd()->formatDefaultTimeZone()],
                $separator,
                ['Download Type', $this->queryParameters->getDownloadType()->value()],
                ['Document Type', $this->queryParameters->getDocumentType()->value()],
                ['Request Type', $this->queryParameters->getRequestType()->value()],
                ['Complemento Cfdi', $this->queryParameters->getComplement()->value()],
                ['uuid', $this->queryParameters->getUuid()->getValue()],
                ['rfcOnBehalf', $this->queryParameters->getRfcOnBehalf()->getValue()],
                /** @phpstan-ignore-next-line */
                ['rfcMatches', implode(',', $this->queryParameters->getRfcMatches()->jsonSerialize())],
            ]
        );
    }

    protected function addParametersQuery()
    {
        $this->endpoints = $this->data['endPoint'] === 'cfdi'
            ? ServiceEndpoints::cfdi() : ServiceEndpoints::retenciones();

        $this->queryParameters = $this->queryParameters
            ->withPeriod(DateTimePeriod::createFromValues($this->data['periodStar'], $this->data['periodEnd']));

        $requestTypeMethod = $this->data['requestType'] === 'xml' ? RequestType::xml() : RequestType::metadata();
        $this->queryParameters = $this->queryParameters->withRequestType($requestTypeMethod);

        $downloadTypeMethod = $this->data['downloadType'] === 'received'
            ? DownloadType::received() : DownloadType::issued();
        $this->queryParameters = $this->queryParameters->withDownloadType($downloadTypeMethod);

        $this->addFiltersQueryPartOne();
        $this->addFiltersQueryPartTwo();
    }

    protected function addFiltersQueryPartOne()
    {
        $documentTypeArray = [
            'I' => DocumentType::ingreso(),
            'E' => DocumentType::egreso(),
            'N' => DocumentType::nomina(),
            'T' => DocumentType::traslado(),
            'P' => DocumentType::pago(),
            'U' => DocumentType::undefined(),
        ];

        $this->queryParameters = $this->queryParameters
            ->withDocumentType($documentTypeArray[$this->data['documentType']]);

        if ($this->data['complementCfdi'] !== null) {
            $this->queryParameters = $this->queryParameters
                ->withComplement(ComplementoCfdi::create($this->data['complementCfdi']));
        }

        $documentStatus = $this->data['documentStatus'];

        if ($documentStatus === 'active') {
            $documentStatusMethod = DocumentStatus::active();
        } elseif ($documentStatus === 'cancelled') {
            $documentStatusMethod = DocumentStatus::cancelled();
        } else {
            $documentStatusMethod = DocumentStatus::undefined();
        }
        $this->queryParameters = $this->queryParameters->withDocumentStatus($documentStatusMethod);
    }

    protected function addFiltersQueryPartTwo()
    {
        if ($this->data['uuid'] !== null) {
            $this->queryParameters = $this->queryParameters->withUuid(Uuid::create($this->data['uuid']));
        }

        if ($this->data['rfcOnBehalf'] !== null) {
            $this->queryParameters = $this->queryParameters
                ->withRfcOnBehalf(RfcOnBehalf::create($this->data['rfcOnBehalf']));
        }

        if (count($this->data['rfcMatch']) > 0) {
            $this->queryParameters = $this->queryParameters->withRfcMatches(
                RfcMatches::createFromValues($this->data['rfcMatch'])
            );
        }
    }

    protected function writeQueryResultFile()
    {
        $nameFile =
            $this->fiel->getRfc()
            .'_'.$this->queryParameters->getPeriod()->getStart()->formatSat()
            .'_'.$this->queryParameters->getPeriod()->getEnd()->formatSat()
            .'_'.$this->queryParameters->getRequestType()->value()
            .'_'.$this->queryParameters->getDownloadType()->value()
            .'-'.$this->queryParameters->getDocumentStatus()->value();

        $content = 'Status'
            ."\n -Code: ".$this->query->getStatus()->getCode()
            ."\n -message: ".$this->query->getStatus()->getMessage()
            ."\n -requestId: ".$this->query->getRequestId();

        Storage::disk('local')
            ->put('datos/'.$this->fiel->getRfc()
                .'/'.$nameFile.'.txt', $content);
        $path = Storage::path('datos/'.$this->fiel->getRfc().'/'.$nameFile.'.txt');
        $this->info('The query result is stored in the following path');
        $this->info($path);
    }
}
