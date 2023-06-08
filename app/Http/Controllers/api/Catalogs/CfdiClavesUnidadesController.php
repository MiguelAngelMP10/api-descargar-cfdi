<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiClavesUnidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiClavesUnidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiClavesUnidades::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'descripcion',
            'notas',
            'vigencia_desde',
            'vigencia_hasta',
            'simbolo',
        ];
    }
}
