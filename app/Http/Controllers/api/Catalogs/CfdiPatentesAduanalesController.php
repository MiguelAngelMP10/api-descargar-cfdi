<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiPatentesAduanales;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiPatentesAduanalesController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiPatentesAduanales::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
