<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Colonias;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40ColoniasController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Colonias::class;

    public function filterableBy(): array
    {
        return [
            'colonia',
            'codigo_postal',
            'texto',
        ];
    }
}
