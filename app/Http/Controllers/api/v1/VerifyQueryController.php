<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use PhpCfdi\SatWsDescargaMasiva\Services\Verify\VerifyResult;

class VerifyQueryController extends Controller
{
    private string $RFC;
    private string $password;
    private bool $retenciones;
    private string $requestId;

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|VerifyResult
     */

    public function verifyQuery(Request $request)
    {
        $this->getParamsRequest($request);
        $satWsServiceHelper = new SatWsService();
        try {
            $service = $satWsServiceHelper->createService(
                $this->RFC,
                $this->password,
                $this->retenciones
            );
            return $service->verify($this->requestId);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    private function getParamsRequest(Request $request)
    {
        $this->RFC = $request->input('RFC');
        $this->password = $request->input('password');
        $this->retenciones = $request->boolean('retenciones');
        $this->requestId = $request->input('requestId');
    }
}
