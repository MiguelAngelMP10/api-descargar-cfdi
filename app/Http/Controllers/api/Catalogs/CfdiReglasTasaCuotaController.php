<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiReglasTasaCuota;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiReglasTasaCuotaController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiReglasTasaCuota::class;

    public function filterableBy(): array
    {
        return [
            'tipo',
            'minimo',
            'valor',
            'impuesto',
            'factor',
            'traslado',
            'retencion',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
