<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaBancos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaBancosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaBancos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'razon_social',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
