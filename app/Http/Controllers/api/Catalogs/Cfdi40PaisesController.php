<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Paises;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40PaisesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Paises::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'patron_codigo_postal',
            'patron_identidad_tributaria',
            'validacion_identidad_tributaria',
            'agrupaciones',
        ];
    }
}
