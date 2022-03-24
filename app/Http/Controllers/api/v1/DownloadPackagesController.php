<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadPackagesRequest;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Download\DownloadResult;
use Illuminate\Http\JsonResponse;

class DownloadPackagesController extends Controller
{
    /**
     * @param DownloadPackagesRequest $request
     * @return JsonResponse
     */
    public function downloadPackages(DownloadPackagesRequest $request): JsonResponse
    {
        $packagesIds = $request->input('packagesIds');
        $rfc = $request->input('RFC');
        $service = $request->getSatWsService();
        // consultar el servicio de verificación
        $messages = [];
        $errorMessages = [];
        $satWsServiceHelper = new SatWsService();
        foreach ($packagesIds as $packageId) {
            $download = $this->download($service, $packageId);
            if (! $download->getStatus()->isAccepted()) {
                $errorMessages[] = sprintf(
                    'El paquete %s no se ha podido descargar: %s',
                    $packageId,
                    $download->getStatus()->getMessage()
                );
                continue;
            }
            $satWsServiceHelper->storePackage($rfc, $packageId, $download);
            $messages[] = "El paquete {$packageId} se ha almacenado";
        }
        return response()->json(['errorMessages' => $errorMessages, 'messages' => $messages]);
    }

    /**
     * @param Service $service
     * @param string $packageId
     * @return DownloadResult
     */
    protected function download(Service $service, string $packageId): DownloadResult
    {
        return $service->download($packageId);
    }
}
