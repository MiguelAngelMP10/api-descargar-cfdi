<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceIncoterms;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceIncotermsController extends Controller
{
    use DisableAuthorization;

    protected $model = CceIncoterms::class;

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
