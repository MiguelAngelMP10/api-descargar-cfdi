<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20TiposContribuyentes;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20TiposContribuyentesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20TiposContribuyentes::class;

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
