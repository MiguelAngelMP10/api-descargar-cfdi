<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Estaciones;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20EstacionesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20Estaciones::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'clave_transporte',
            'nacionalidad',
            'designador_iata',
            'linea_ferrea',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
