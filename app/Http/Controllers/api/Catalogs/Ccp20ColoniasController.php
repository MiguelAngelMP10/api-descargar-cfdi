<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Colonias;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ccp20ColoniasController extends Controller
{
    use DisableAuthorization;

    protected $model = Ccp20Colonias::class;

    public function filterableBy(): array
    {
        return [
            'colonia',
            'codigo_postal',
            'texto',
        ];
    }
}
