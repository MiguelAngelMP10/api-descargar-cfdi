<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20FigurasTransporte;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20FigurasTransporteController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20FigurasTransporte::class;

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
