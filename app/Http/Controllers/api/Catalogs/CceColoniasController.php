<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceColonias;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceColoniasController extends Controller
{
    use DisableAuthorization;

    protected $model = CceColonias::class;

    public function filterableBy(): array
    {
        return [
            'colonia',
            'codigo_postal',
            'asentamiento',
        ];
    }
}
