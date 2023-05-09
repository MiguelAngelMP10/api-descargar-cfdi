<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\FielStoreRequest;
use Inertia\Inertia;
use Inertia\Response;
use PhpCfdi\Credentials\Credential;
use Throwable;

class FielController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Config/Fiel', ['fiels' => [['a' => 1, 'b' => 2]]]);
    }

    public function store(FielStoreRequest $request)
    {
        try {
            $fiel = Credential::create(
                $request->input('cer'),
                $request->input('key'),
                $request->input('password')
            );

            $certificado = $fiel->certificate();
            dd($certificado->rfc(), $certificado->legalName());
        } catch (Throwable $exception) {
            return redirect()->route("config-fiel.index")->with('error', $exception->getMessage());
        }
    }
}
