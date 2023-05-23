<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40NumerosPedimentoAduana;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40NumerosPedimentoAduanaController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40NumerosPedimentoAduana::class;

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
