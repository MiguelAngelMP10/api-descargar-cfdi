<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Localidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40LocalidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Localidades::class;

    public function filterableBy(): array
    {
        return [
            'localidad',
            'estado',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
