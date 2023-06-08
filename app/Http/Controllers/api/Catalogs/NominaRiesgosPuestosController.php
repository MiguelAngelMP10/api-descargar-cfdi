<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaRiesgosPuestos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaRiesgosPuestosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaRiesgosPuestos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
