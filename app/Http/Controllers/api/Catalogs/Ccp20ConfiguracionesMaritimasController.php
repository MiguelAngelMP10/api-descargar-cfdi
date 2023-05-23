<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20ConfiguracionesMaritimas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20ConfiguracionesMaritimasController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20ConfiguracionesMaritimas::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
