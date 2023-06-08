<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40CodigosPostales;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40CodigosPostalesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40CodigosPostales::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'estado',
            'municipio',
            'localidad',
            'estimulo_frontera',
            'vigencia_desde',
            'vigencia_hasta',
            'huso_descripcion',
            'huso_verano_mes_inicio',
            'huso_verano_dia_inicio',
            'huso_verano_hora_inicio',
            'huso_verano_diferencia',
            'huso_invierno_mes_inicio',
            'huso_invierno_dia_inicio',
            'huso_invierno_hora_inicio',
            'huso_invierno_diferencia',
        ];
    }
}
