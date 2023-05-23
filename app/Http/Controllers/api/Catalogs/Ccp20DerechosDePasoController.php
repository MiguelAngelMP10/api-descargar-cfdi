<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20DerechosDePaso;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20DerechosDePasoController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20DerechosDePaso::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'entre',
            'hasta',
            'otorga_recibe',
            'concesionario',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
