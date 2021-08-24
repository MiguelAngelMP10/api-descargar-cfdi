<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class VerifyQueryController extends Controller
{
    public function verifyQuery(Request $request)
    {
        $satWsServiceHelper = new SatWsService();
        try {
            $service = $satWsServiceHelper->createService(
                $request->input('RFC'),
                $request->input('password'),
                $request->boolean('retenciones')
            );
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        $requestId = $request->input('requestId');

        // consultar el servicio de verificación
        $verify = $service->verify($requestId);

        // revisar que el proceso de verificación fue correcto
        if (! $verify->getStatus()->isAccepted()) {
            return response()->json([
                'message' => "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}",
            ]);
        }

        // revisar que la consulta no haya sido rechazada
        if (! $verify->getCodeRequest()->isAccepted()) {
            return response()->json([
                'message' => "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}",
            ]);
        }

        // revisar el progreso de la generación de los paquetes
        $statusRequest = $verify->getStatusRequest();
        if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
            return response()->json([
                'message' => "La solicitud {$requestId} no se puede completar",
            ]);
        }

        if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
            return response()->json([
                'message' => "La solicitud {$requestId} se está procesando",
            ]);
        }

        if ($statusRequest->isFinished()) {
            return response()->json([
                'message' => "La solicitud {$requestId} está lista",
                'numPaquetes' => "Se encontraron {$verify->countPackages()} paquetes",
                'packagesIds' => $verify->getPackagesIds(),
            ]);
        }
    }
}
