<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposServicio;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20TiposServicioController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20TiposServicio::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'contenedor',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
