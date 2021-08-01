<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class DownloadPackagesController extends Controller
{
    public function downloadPackages(Request $request)
    {
        $packagesIds = $request->input('packagesIds');

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

        // consultar el servicio de verificación
        $messages = [];
        $errorMessages = [];
        foreach ($packagesIds as $packageId) {
            $download = $service->download($packageId);
            if (!$download->getStatus()->isAccepted()) {
                $errorMessages[] =  "El paquete {$packageId} no se ha podido descargar: {$download->getStatus()->getMessage()}";
                continue;
            }
            $zipfile = "$packageId.zip";
            file_put_contents($zipfile, $download->getPackageContent());
            $messages[] =  "El paquete {$packageId} se ha almacenado";
        }
        return response()->json(['errorMessages' => $errorMessages, 'messages' => $messages]);
    }
}
