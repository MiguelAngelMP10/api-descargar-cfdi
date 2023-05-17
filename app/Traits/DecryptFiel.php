<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;

trait DecryptFiel
{
    private function decryptFiel($fielDB): Fiel
    {
        return Fiel::create(
            Crypt::decryptString($fielDB->cer),
            Crypt::decryptString($fielDB->key),
            Crypt::decryptString($fielDB->password)
        );
    }
}
