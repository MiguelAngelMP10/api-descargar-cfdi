<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20ClavesUnidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20ClavesUnidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20ClavesUnidades::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'descripcion',
            'nota',
            'vigencia_desde',
            'vigencia_hasta',
            'simbolo',
            'bandera',
        ];
    }
}
