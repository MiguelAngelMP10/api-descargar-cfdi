<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40TiposFactores;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40TiposFactoresController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40TiposFactores::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
