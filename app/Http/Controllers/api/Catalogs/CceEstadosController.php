<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceEstados;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceEstadosController extends Controller
{
    use DisableAuthorization;

    protected $model = CceEstados::class;

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
