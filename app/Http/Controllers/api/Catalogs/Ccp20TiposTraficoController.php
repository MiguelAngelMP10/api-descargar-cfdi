<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposTrafico;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20TiposTraficoController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20TiposTrafico::class;

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
