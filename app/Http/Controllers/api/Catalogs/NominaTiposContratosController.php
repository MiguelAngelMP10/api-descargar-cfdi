<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposContratos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposContratosController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposContratos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
