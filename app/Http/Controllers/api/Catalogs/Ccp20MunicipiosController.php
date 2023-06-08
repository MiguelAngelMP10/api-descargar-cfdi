<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Municipios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20MunicipiosController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20Municipios::class;

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
