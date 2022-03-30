<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Verify\VerifyResult;

class VerifyQueryController extends Controller
{
    private string $RFC;
    private string $password;
    private bool $retenciones;
    private Service $service;
    private string $requestId;

    /**
     * @param Request $request
     *
     * @return void
     */

    public function verifyQuery(Request $request)
    {
        $this->getParamsRequest($request);
        $this->createService();
        $verify = $this->service->verify($this->requestId);
        $this->evaluateResponse($verify);
    }

    private function getParamsRequest(Request $request)
    {
        $this->RFC = $request->input('RFC');
        $this->password = $request->input('password');
        $this->retenciones = $request->boolean('retenciones');
        $this->requestId = $request->input('requestId');
    }

    private function createService(): void
    {
        $satWsServiceHelper = new SatWsService();
        try {
            $this->service = $satWsServiceHelper->createService(
                $this->RFC,
                $this->password,
                $this->retenciones
            );
        } catch (Exception $exception) {
            response()->json(['message' => $exception->getMessage()], 422);
            return;
        }
    }

    private function evaluateResponse(VerifyResult $verify): void
    {
        if (! $verify->getStatus()->isAccepted()) {
            response()->json([
                'message' => "Fallo al verificar la consulta {$this->requestId}: {$verify->getStatus()->getMessage()}",
            ]);
            return;
        }

        if (! $verify->getCodeRequest()->isAccepted()) {
            response()->json([
                'message' => "La solicitud {$this->requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}",
            ]);
            return;
        }

        $this->evaluateStatusRequest($verify);
    }

    private function evaluateStatusRequest(VerifyResult $verify)
    {
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            response()->json([
                'message' => "La solicitud {$this->requestId} no se puede completar",
            ]);
            return;
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            response()->json([
                'message' => "La solicitud {$this->requestId} se está procesando",
            ]);
            return;
        }

        if ($statusRequest->isFinished()) {
            response()->json([
                'message' => "La solicitud {$this->requestId} está lista",
                'numPaquetes' => "Se encontraron {$verify->countPackages()} paquetes",
                'packagesIds' => $verify->getPackagesIds(),
            ]);
        }
    }
}
