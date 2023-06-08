<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposEstacion;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20TiposEstacionController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20TiposEstacion::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'claves_transportes',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
