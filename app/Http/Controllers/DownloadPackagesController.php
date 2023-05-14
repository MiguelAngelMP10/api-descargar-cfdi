<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Query;
use App\Traits\DecryptFiel;
use App\Traits\ParameterEvaluations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class DownloadPackagesController extends Controller
{
    use DecryptFiel;
    use ParameterEvaluations;

    public function downloadPackages(Request $request, Query $query): RedirectResponse
    {
        try {
            $webClient = new GuzzleWebClient();

            $fielDB = $request->user()->fiels()->where('rfc', '=', $query->rfc)->first();
            $requestBuilder = new FielRequestBuilder($this->decryptFiel($fielDB));

            $service = new Service($requestBuilder, $webClient, null, $this->getEndpoints($query->endPoint));
            $message = '';
            foreach ($query->packeges()->get() as $package) {
                $this->downloadPackageSave($package, $service, $query->rfc);
                $message .= 'Se almaceno el paquete con id: ' . $package->packageId . '<br>';
            }

            return redirect()
                ->route('queries.show', $query->id)
                ->with('success', $message);
        } catch (\Exception $exception) {
            return redirect()->route('queries.show', $query->id)->with('error', $exception->getMessage());
        }
    }

    private function downloadPackageSave(Package $package, Service $service, $rfc): void
    {
        $download = $service->download($package->packageId);
        $package->statusCode = $download->getStatus()->getCode();
        $package->statusMessage = $download->getStatus()->getMessage();
        $package->packageSize = $download->getPackageSize();
        $pathSave = $rfc . '/' . $package->packageId . '.zip';
        Storage::put($pathSave, $download->getPackageContent());
        $package->path = $pathSave;
        $package->save();
    }
}
