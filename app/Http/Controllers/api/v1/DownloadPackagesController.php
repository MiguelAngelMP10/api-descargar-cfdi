<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadPackagesRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpCfdi\Rfc\Exceptions\InvalidExpressionToParseException;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Download\DownloadResult;

class DownloadPackagesController extends Controller
{
    private string $cer;
    private string $key;
    private string $password;
    private string|null $endPoint;
    private $packagesIds;


    /**
     * @param DownloadPackagesRequest $request
     *
     * @return JsonResponse
     * @throws InvalidExpressionToParseException
     * @throws Exception
     */
    public function downloadPackages(DownloadPackagesRequest $request): JsonResponse
    {
        $satWsServiceHelper = new SatWsService();
        $this->getParamsRequest($request);
        $service = $satWsServiceHelper->createService($this->cer, $this->key, $this->password, $this->endPoint);
        // consultar el servicio de verificación
        $messages = [];
        $errorMessages = [];
        $satWsServiceHelper = new SatWsService();
        $fiel = $satWsServiceHelper->createFiel($this->cer, $this->key, $this->password);
        foreach ($this->packagesIds as $packageId) {
            $download = $this->download($service, $packageId);
            if (!$download->getStatus()->isAccepted()) {
                $errorMessages[] = sprintf(
                    'El paquete %s no se ha podido descargar: %s',
                    $packageId,
                    $download->getStatus()->getMessage()
                );
                continue;
            }
            $satWsServiceHelper->storePackage($fiel->getRfc(), $packageId, $download);
            $messages[] = "El paquete {$packageId} se ha almacenado";
        }
        return response()->json(['errorMessages' => $errorMessages, 'messages' => $messages]);
    }

    /**
     * @param Service $service
     * @param string $packageId
     *
     * @return DownloadResult
     */
    protected function download(Service $service, string $packageId): DownloadResult
    {
        return $service->download($packageId);
    }

    private function getParamsRequest(DownloadPackagesRequest $request): void
    {
        $this->cer = $request->input('cer');
        $this->key = $request->input('key');
        $this->password = $request->input('password');
        $this->endPoint = $request->input('endPoint');
        $this->packagesIds = $request->input('packagesIds');
    }
}
