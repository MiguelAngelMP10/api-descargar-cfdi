<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20MaterialesPeligrosos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20MaterialesPeligrososController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20MaterialesPeligrosos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'clase_o_div',
            'peligro_secundario',
            'nombre_tecnico',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
