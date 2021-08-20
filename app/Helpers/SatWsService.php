<?php

declare(strict_types=1);

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Download\DownloadResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class SatWsService
{
    public function createService(string $rfc, string $password, bool $retenciones): Service
    {
        $contentCer = Storage::get($this->obtainCertificatePath($rfc));
        $contentKey = Storage::get($this->obtainPrivateKeyPath($rfc));

        $fiel = $this->createFiel($contentCer, $contentKey, $password);

        // creación del web client basado en Guzzle que implementa WebClientInterface
        // para usarlo necesitas instalar guzzlehttp/guzzle pues no es una dependencia directa
        $webClient = new GuzzleWebClient();

        // creación del objeto encargado de crear las solicitudes firmadas usando una FIEL
        $requestBuilder = new FielRequestBuilder($fiel);

        // Creación del servicio
        $endpoints = (! $retenciones) ? ServiceEndpoints::cfdi() : ServiceEndpoints::retenciones();
        return new Service($requestBuilder, $webClient, null, $endpoints);
    }

    public function createFiel(string $contentCer, string $contentKey, string $password): Fiel
    {
        $fiel = Fiel::create($contentCer, $contentKey, $password);

        // verificar que la FIEL sea válida (no sea CSD y sea vigente acorde a la fecha del sistema)
        if (! $fiel->isValid()) {
            throw new Exception('La FIEL no es valida');
        }

        return $fiel;
    }

    public function obtainCertificatePath(string $rfc): string
    {
        return 'datos/' . $rfc . "/" . $rfc . '.cer';
    }

    public function obtainPrivateKeyPath(string $rfc): string
    {
        return 'datos/' . $rfc . "/" . $rfc . '.key';
    }

    public function obtainPackagePath(string $rfc, string $packageId): string
    {
        if ($packageId !== '') {
            $packageId = $packageId . '.zip';
        }
        return 'datos/' . $rfc . '/packages/' . $packageId;
    }

    public function storePackage(string $rfc, string $packageId, DownloadResult $package): void
    {
        $path = $this->obtainPackagePath($rfc, $packageId);
        Storage::put($path, $package->getPackageContent());
    }
}
