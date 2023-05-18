<?php

use App\Http\Controllers\CfdiToJsonController;
use App\Http\Controllers\Config\FielController;
use App\Http\Controllers\DownloadPackagesController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ResponseQueryVerificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('queries', QueryController::class)->except(['edit', 'update', 'destroy']);
    Route::get('config/fiel', [FielController::class, 'create'])->name('config-fiel.create');
    Route::post('config/fiel', [FielController::class, 'store'])->name('config-fiel.store');
    Route::delete('config/fiel/{fiel}', [FielController::class, 'destroy'])->name('config-fiel.destroy');
    Route::get('verify-query/{query}', [ResponseQueryVerificationController::class, 'verifyQuery'])
        ->name('verify.query');
    Route::get('download-packages/{query}', [DownloadPackagesController::class, 'downloadPackages'])
        ->name('download.packages');
    Route::get('cfdi-to-json', [CfdiToJsonController::class, 'cfdiToJson'])->name('cfdi.to.json');
});
