<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20Ejercicios;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20EjerciciosController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20Ejercicios::class;

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
