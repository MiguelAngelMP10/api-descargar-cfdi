<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20ProductosServicios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20ProductosServiciosController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20ProductosServicios::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'similares',
            'material_peligroso',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
