<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Contenedores;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20ContenedoresController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20Contenedores::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'descripcion',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
