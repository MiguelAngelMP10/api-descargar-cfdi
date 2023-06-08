<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceLocalidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceLocalidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = CceLocalidades::class;

    public function filterableBy(): array
    {
        return [
            'localidad',
            'estado',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
