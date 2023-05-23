<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Monedas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40MonedasController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Monedas::class;

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
