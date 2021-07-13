<?php

use App\Http\Controllers\api\v1\DownloadPackagesController;
use App\Http\Controllers\api\v1\MakeQueryController;
use App\Http\Controllers\api\v1\SendCerKeyController;
use App\Http\Controllers\api\v1\VerifyQueryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('v1/send-cer-key', [SendCerKeyController::class, 'sendCerKey']);

Route::post('v1/make-query', [MakeQueryController::class, 'makeQuery']);

Route::post('v1/verify-query', [VerifyQueryController::class, 'verifyQuery']);

Route::post('v1/download-packages', [DownloadPackagesController::class, 'downloadPackages']);