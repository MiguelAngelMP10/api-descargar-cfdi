<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20AutorizacionesNaviero;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20AutorizacionesNavieroController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20AutorizacionesNaviero::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
