<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Aduanas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40AduanasController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Aduanas::class;

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
