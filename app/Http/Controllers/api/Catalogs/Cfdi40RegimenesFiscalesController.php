<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40RegimenesFiscales;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40RegimenesFiscalesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40RegimenesFiscales::class;

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
