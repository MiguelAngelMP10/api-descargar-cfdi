<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendCerKeyRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class SendCerKeyController extends Controller
{
    public function sendCerKey(SendCerKeyRequest $request): JsonResponse
    {
        $satWsService = new SatWsService();
        try {
            $fiel = $satWsService->createFiel(
                $request->file('cer')->getContent(),
                $request->file('key')->getContent(),
                $request->input('password')
            );
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Certificado, llave privada o contraseña inválida',
                'code' => $exception->getMessage(),
            ], 422);
        }

        $rfc = $fiel->getRfc();
        $certificatePath = $satWsService->obtainCertificatePath($rfc);
        $privateKeyPath = $satWsService->obtainPrivateKeyPath($rfc);

        $pathCer = $request->file('cer')->storeAs(dirname($certificatePath), basename($certificatePath));
        $pathKey = $request->file('key')->storeAs(dirname($privateKeyPath), basename($privateKeyPath));

        return response()->json([
            'pathCer' => $pathCer,
            'pathKey' => $pathKey,
        ]);
    }
}
