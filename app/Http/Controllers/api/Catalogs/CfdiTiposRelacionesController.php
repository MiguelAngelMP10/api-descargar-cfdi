<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiTiposRelaciones;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiTiposRelacionesController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiTiposRelaciones::class;

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
