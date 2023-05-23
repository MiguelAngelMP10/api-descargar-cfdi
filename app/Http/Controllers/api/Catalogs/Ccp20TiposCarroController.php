<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposCarro;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20TiposCarroController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20TiposCarro::class;

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
