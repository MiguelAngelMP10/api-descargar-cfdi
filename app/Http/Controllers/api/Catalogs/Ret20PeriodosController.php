<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20Periodos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20PeriodosController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20Periodos::class;

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
