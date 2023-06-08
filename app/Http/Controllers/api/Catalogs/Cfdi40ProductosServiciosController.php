<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40ProductosServicios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40ProductosServiciosController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40ProductosServicios::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'iva_trasladado',
            'ieps_trasladado',
            'complemento',
            'vigencia_desde',
            'vigencia_hasta',
            'estimulo_frontera',
            'similares',
        ];
    }
}
