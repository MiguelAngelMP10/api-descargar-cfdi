<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Localidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20LocalidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20Localidades::class;

    public function filterableBy(): array
    {
        return [
            'localidad',
            'estado',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
