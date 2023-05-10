<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\FielStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;
use Inertia\Response;
use PhpCfdi\Credentials\Credential;
use Throwable;

class FielController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Config/Fiel', ['fiels' => $request->user()->fiels()->get()]);
    }

    public function store(FielStoreRequest $request): RedirectResponse
    {
        try {
            $fiel = Credential::create(
                $request->input('cer'),
                $request->input('key'),
                $request->input('password')
            );

            $certificado = $fiel->certificate();

            $request->user()->fiels()->create([
                'rfc' => $certificado->rfc(),
                'legalName' => $certificado->legalName(),
                'cer' => Crypt::encryptString($request->input('cer')),
                'key' => Crypt::encryptString($request->input('key')),
                'password' => Crypt::encryptString($request->input('password')),
            ]);
            return redirect()->route("config-fiel.index")->with('success', 'The Fiel was added correctly');
        } catch (Throwable $exception) {
            return redirect()->route("config-fiel.index")->with('error', $exception->getMessage());
        }
    }
}
