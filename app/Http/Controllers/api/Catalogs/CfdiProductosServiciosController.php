<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiProductosServicios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiProductosServiciosController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiProductosServicios::class;

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
