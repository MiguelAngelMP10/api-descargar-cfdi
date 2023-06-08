<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiAduanas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiAduanasController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiAduanas::class;

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
