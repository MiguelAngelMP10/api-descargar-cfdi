<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20Periodicidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20PeriodicidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20Periodicidades::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'nombre_complemento',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
