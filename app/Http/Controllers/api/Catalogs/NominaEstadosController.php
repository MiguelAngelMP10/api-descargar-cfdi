<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaEstados;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaEstadosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaEstados::class;

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
