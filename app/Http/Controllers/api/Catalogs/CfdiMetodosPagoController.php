<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiMetodosPago;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiMetodosPagoController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiMetodosPago::class;

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
