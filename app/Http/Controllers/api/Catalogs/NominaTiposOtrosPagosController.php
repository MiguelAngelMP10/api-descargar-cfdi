<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposOtrosPagos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposOtrosPagosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposOtrosPagos::class;

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
