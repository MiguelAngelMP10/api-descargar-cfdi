<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40ClavesUnidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40ClavesUnidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40ClavesUnidades::class;

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
