<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceMunicipios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceMunicipiosController extends Controller
{
    use DisableAuthorization;

    protected $model = CceMunicipios::class;

    public function filterableBy(): array
    {
        return [
            'municipio',
            'estado',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
