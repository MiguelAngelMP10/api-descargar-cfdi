<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiMonedas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiMonedasController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiMonedas::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'decimales',
            'porcentaje_variacion',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
