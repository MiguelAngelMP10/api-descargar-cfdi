<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiUsosCfdi;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiUsosCfdiController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiUsosCfdi::class;

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
