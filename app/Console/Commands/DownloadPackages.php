<?php

namespace App\Console\Commands;

use App\Helpers\SatWsService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class DownloadPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:download:packages
                            {cer : Certificate path}
                            {key : Key path}
                            {--p|password= : Password FIEL}
                            {--endPoint=cfdi : Service endpoint. [cfdi, retenciones]}
                            {--i|packageId=* : Package Id}
                            {--pathSave= : Path to save packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download web service packages';

    protected $validator;

    private Fiel $fiel;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->validateOptions();
        if ($this->validator->passes()) {
            try {
                $this->processFiel();
                if ($this->fiel->isValid()) {
                    $packagesIds = $this->option('packageId');
                    $this->downloadPackages($packagesIds);

                    return 0;
                }

                return 1;
            } catch (Exception $exception) {
                $this->error($exception->getMessage());

                return 1;
            }
        } else {
            $this->printErrors();

            return 1;
        }
    }

    private function validateOptions()
    {
        $this->validator = Validator::make([
            'password' => $this->option('password'),
            'endPoint' => $this->option('endPoint'),
            'packageId' => $this->option('packageId'),
            'pathSave' => $this->option('pathSave'),
        ], ['password' => ['required', 'min:5'],
            'endPoint' => ['required', Rule::in(['cfdi', 'retenciones'])],
            'packageId' => ['required', 'array'],
            'pathSave' => ['nullable', 'string'],
        ], [
            'requestId.required' => 'The requestId field is required.',
            'endPoint.required' => 'The endPoint field is required.',
            'endPoint.in' => 'The endPoint must be one of the following types: :values.',
        ]);
    }

    private function downloadPackages($packagesIds)
    {
        foreach ($packagesIds as $packageId) {
            $webClient = new GuzzleWebClient();
            $requestBuilder = new FielRequestBuilder($this->fiel);
            $endpoints = $this->option('endPoint') === 'cfdi'
                ? ServiceEndpoints::cfdi() : ServiceEndpoints::retenciones();
            $service = new Service($requestBuilder, $webClient, null, $endpoints);
            $download = $service->download($packageId);
            if (! $download->getStatus()->isAccepted()) {
                $this->warn('The package '.$packageId.' unable to download: '.
                    $download->getStatus()->getMessage());

                continue;
            }
            if (is_null($this->option('pathSave'))) {
                $path = $this->obtainPackagePath($this->fiel->getRfc(), $packageId);
                Storage::put($path, $download->getPackageContent());
                $this->info("El paquete {$path} se ha almacenado ");
            } else {
                $pathSave = $this->option('pathSave');
                file_put_contents($pathSave.$packageId.'.zip', $download->getPackageContent());
                $this->info("El paquete {$pathSave}{$packageId} se ha almacenado ");
            }
        }
    }

    private function obtainPackagePath(string $rfc, string $packageId): string
    {
        if ($packageId !== '') {
            $packageId .= '.zip';
        }

        return 'datos/'.$rfc.'/packages/'.$packageId;
    }

    private function printErrors()
    {
        $this->alert('ERRORS');
        foreach ($this->validator->errors()->all() as $error) {
            $this->error($error);
        }
    }

    /**
     * @throws Exception
     */
    private function processFiel()
    {
        $contentCer = file_get_contents($this->argument('cer'));
        $contentKey = file_get_contents($this->argument('key'));
        $satWsService = new SatWsService();
        $this->fiel = $satWsService->createFiel(
            $contentCer,
            $contentKey,
            $this->option('password')
        );
    }
}
