<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Municipios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40MunicipiosController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Municipios::class;

    public function filterableBy(): array
    {
        return [
            'municipio',
            'estado',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
