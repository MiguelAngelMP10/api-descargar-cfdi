<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiImpuestos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiImpuestosController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiImpuestos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'retencion',
            'traslado',
            'ambito',
            'entidad',
        ];
    }
}
