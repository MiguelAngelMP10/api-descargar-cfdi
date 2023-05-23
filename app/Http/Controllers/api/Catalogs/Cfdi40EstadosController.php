<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Estados;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40EstadosController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Estados::class;

    public function filterableBy(): array
    {
        return [
            'estado',
            'pais',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
