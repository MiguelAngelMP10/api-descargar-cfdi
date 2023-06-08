<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40TiposComprobantes;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40TiposComprobantesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40TiposComprobantes::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'valor_maximo',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
