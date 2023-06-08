<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaPeriodicidadesPagos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaPeriodicidadesPagosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaPeriodicidadesPagos::class;

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
