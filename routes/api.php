<?php

use App\Http\Controllers\api\v1\DownloadPackagesController;
use App\Http\Controllers\api\v1\MakeQueryController;
use App\Http\Controllers\api\v1\PackagesController;
use App\Http\Controllers\api\v1\SendCerKeyController;
use App\Http\Controllers\api\v1\VerifyQueryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpCfdi\Rfc\Exceptions\InvalidExpressionToParseException;
use PhpCfdi\Rfc\Rfc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

Route::middleware('auth:api')->get('/user', fn (Request $request) => $request->user());

Route::post('v1/send-cer-key', [SendCerKeyController::class, 'sendCerKey']);

Route::post('v1/make-query', [MakeQueryController::class, 'makeQuery']);

Route::post('v1/verify-query', [VerifyQueryController::class, 'verifyQuery']);

Route::post('v1/download-packages', [DownloadPackagesController::class, 'downloadPackages']);

Route::get('v1/{rfc}/packages', [PackagesController::class, 'index']);
Route::get('v1/{rfc}/packages/{packageId}', [PackagesController::class, 'download']);
Route::delete('v1/{rfc}/packages/{packageId}', [PackagesController::class, 'delete']);

/*
 * convert routes `{rfc}` parameter to `Rfc` object
 */
Route::bind('rfc', function (string $value): Rfc {
    try {
        return Rfc::parse($value);
    } catch (InvalidExpressionToParseException $exception) {
        throw new NotFoundHttpException("Invalid RFC value ${value}.");
    }
});
