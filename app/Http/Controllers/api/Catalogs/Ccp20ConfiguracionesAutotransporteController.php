<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20ConfiguracionesAutotransporte;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20ConfiguracionesAutotransporteController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20ConfiguracionesAutotransporte::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'numero_de_ejes',
            'numero_de_llantas',
            'remolque',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
