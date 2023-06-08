<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiNumerosPedimentoAduana;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiNumerosPedimentoAduanaController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiNumerosPedimentoAduana::class;

    public function filterableBy(): array
    {
        return [
            'aduana',
            'patente',
            'ejercicio',
            'cantidad',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
