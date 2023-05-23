<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40UsosCfdi;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40UsosCfdiController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40UsosCfdi::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'aplica_fisica',
            'aplica_moral',
            'vigencia_desde',
            'vigencia_hasta',
            'regimenes_fiscales_receptores',
        ];
    }
}
