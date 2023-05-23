<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposPermiso;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20TiposPermisoController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20TiposPermiso::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'clave_transporte',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
