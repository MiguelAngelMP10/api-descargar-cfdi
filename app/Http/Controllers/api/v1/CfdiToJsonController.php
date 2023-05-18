<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CfdiToJsonRequest;
use Illuminate\Http\JsonResponse;
use PhpCfdi\CfdiToJson\JsonConverter;

class CfdiToJsonController extends Controller
{
    public function cfdiToJson(CfdiToJsonRequest $request): JsonResponse
    {
        try {
            $cfdis = $request->file('cfdis');
            $cfdisArray = $this->processFilesCfdis($cfdis);
            return response()->json($cfdisArray);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function processFilesCfdis($cfdis): array
    {
        if (count($cfdis) > 1) {
            $arrayJson = [];
            foreach ($cfdis as $cfdi) {
                $arrayJson[] = JsonConverter::convertToArray($cfdi->getContent());
            }
            return $arrayJson;
        }
        return JsonConverter::convertToArray($cfdis[0]->getContent());
    }
}
