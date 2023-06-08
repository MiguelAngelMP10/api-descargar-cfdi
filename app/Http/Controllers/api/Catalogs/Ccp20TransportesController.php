<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Transportes;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20TransportesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20Transportes::class;

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
