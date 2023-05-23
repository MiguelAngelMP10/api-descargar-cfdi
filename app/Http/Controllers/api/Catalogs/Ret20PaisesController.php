<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20Paises;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20PaisesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20Paises::class;

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
