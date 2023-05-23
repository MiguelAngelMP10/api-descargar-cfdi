<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceFraccionesArancelarias;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceFraccionesArancelariasController extends Controller
{
    use DisableAuthorization;

    protected $model = CceFraccionesArancelarias::class;

    public function filterableBy(): array
    {
        return [
            'fraccion',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
            'unidad',
        ];
    }
}
