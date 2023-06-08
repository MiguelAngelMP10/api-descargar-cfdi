<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceTiposOperacion;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceTiposOperacionController extends Controller
{
    use DisableAuthorization;

    protected $model = CceTiposOperacion::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
