<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Impuestos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40ImpuestosController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Impuestos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'retencion',
            'traslado',
            'ambito',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
