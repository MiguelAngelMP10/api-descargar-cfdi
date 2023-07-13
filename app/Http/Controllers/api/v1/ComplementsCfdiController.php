<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;

class ComplementsCfdiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json(['data' => ComplementoCfdi::getLabels()]);
    }
}
