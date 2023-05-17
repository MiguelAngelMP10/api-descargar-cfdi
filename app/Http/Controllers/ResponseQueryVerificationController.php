<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Query;
use App\Models\ResponseQueryVerification;
use App\Traits\DecryptFiel;
use App\Traits\ParameterEvaluations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class ResponseQueryVerificationController extends Controller
{
    use DecryptFiel;
    use ParameterEvaluations;

    public function verifyQuery(Request $request, Query $query): RedirectResponse
    {
        $webClient = new GuzzleWebClient();
        $fielDB = $request->user()->fiels()->where('rfc', '=', $query->rfc)->first();
        $requestBuilder = new FielRequestBuilder($this->decryptFiel($fielDB));
        $service = new Service($requestBuilder, $webClient, null, $this->getEndpoints($query->endPoint));

        $very = $service->verify($query->requestId);

        ResponseQueryVerification::create([
            'query_id' => $query->id,
            'statusCode' => $very->getStatus()->getCode(),
            'statusMessage' => $very->getStatus()->getMessage(),
            'statusRequestMessage' => $very->getStatusRequest()->getMessage(),
            'statusRequestName' => $very->getStatusRequest()->getName(),
            'statusRequestEntryIndex' => $very->getStatusRequest()->getEntryIndex(),
            'codeRequestValue' => $very->getCodeRequest()->getValue(),
            'codeRequestName' => $very->getCodeRequest()->getName(),
            'codeRequestMessage' => $very->getCodeRequest()->getMessage(),
        ]);
        $query->numeroCFDIs = $very->getNumberCfdis();
        $query->save();
        $this->insertPackeges($very->getPackagesIds(), $query);

        return back()->with('success', 'Consulta verificada '.implode(', <br>', $very->getPackagesIds()));
    }

    private function insertPackeges(array $packagesIds, Query $query): void
    {
        foreach ($packagesIds as $packagesId) {
            $package = new Package();
            $package->query_id = $query->id;
            $package->packageId = $packagesId;
            $package->save();
        }
    }
}
