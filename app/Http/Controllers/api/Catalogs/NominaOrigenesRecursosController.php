<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaOrigenesRecursos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaOrigenesRecursosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaOrigenesRecursos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
