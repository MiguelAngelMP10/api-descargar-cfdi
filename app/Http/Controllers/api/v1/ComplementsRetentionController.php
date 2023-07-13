<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoRetenciones;

class ComplementsRetentionController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(['data' => ComplementoRetenciones::getLabels()]);
    }
}
