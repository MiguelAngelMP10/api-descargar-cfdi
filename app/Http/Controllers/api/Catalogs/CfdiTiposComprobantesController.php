<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiTiposComprobantes;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiTiposComprobantesController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiTiposComprobantes::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'valor_maximo',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
