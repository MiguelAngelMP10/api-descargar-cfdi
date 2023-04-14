<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyQueryPostRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use PhpCfdi\SatWsDescargaMasiva\Services\Verify\VerifyResult;

class VerifyQueryController extends Controller
{
    private string $key;
    private string $cer;
    private string|null $endPoint;
    private string $password;
    private string $requestId;

    /**
     * @param VerifyQueryPostRequest $request
     *
     * @return JsonResponse|VerifyResult
     */

    public function verifyQuery(VerifyQueryPostRequest $request): VerifyResult|JsonResponse
    {
        $this->getParamsRequest($request);
        $satWsServiceHelper = new SatWsService();
        try {
            $service = $satWsServiceHelper->createService($this->cer, $this->key, $this->password, $this->endPoint);
            return $service->verify($this->requestId);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    private function getParamsRequest(VerifyQueryPostRequest $request): void
    {
        $this->cer = $request->input('cer');
        $this->key = $request->input('key');
        $this->password = $request->input('password');
        $this->endPoint = $request->input('endPoint');
        $this->requestId = $request->input('requestId');
    }
}
