<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceUnidadesMedida;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceUnidadesMedidaController extends Controller
{
    use DisableAuthorization;

    protected $model = CceUnidadesMedida::class;

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
