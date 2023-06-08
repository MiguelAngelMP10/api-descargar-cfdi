<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiRegimenesFiscales;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiRegimenesFiscalesController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiRegimenesFiscales::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'aplica_fisica',
            'aplica_moral',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
