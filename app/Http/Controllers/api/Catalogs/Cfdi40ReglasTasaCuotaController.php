<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40ReglasTasaCuota;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40ReglasTasaCuotaController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40ReglasTasaCuota::class;

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
