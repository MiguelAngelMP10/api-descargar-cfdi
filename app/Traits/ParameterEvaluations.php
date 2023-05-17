<?php

namespace App\Traits;

use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;

trait ParameterEvaluations
{
    protected function getEndpoints($endPoint): ServiceEndpoints
    {
        return match ($endPoint) {
            'retenciones' => ServiceEndpoints::retenciones(),
            default => ServiceEndpoints::cfdi(),
        };
    }

    protected function getDownloadType($downloadType): DownloadType
    {
        return match ($downloadType) {
            'received' => DownloadType::received(),
            default => DownloadType::issued(),
        };
    }

    protected function getRequestType($requestType): RequestType
    {
        return match ($requestType) {
            'xml' => RequestType::xml(),
            default => RequestType::metadata(),
        };
    }
}
