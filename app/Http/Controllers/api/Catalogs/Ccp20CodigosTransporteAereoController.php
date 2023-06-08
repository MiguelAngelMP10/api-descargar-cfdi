<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20CodigosTransporteAereo;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20CodigosTransporteAereoController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20CodigosTransporteAereo::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'nacionalidad',
            'texto',
            'designador_oaci',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
