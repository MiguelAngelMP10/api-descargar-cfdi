<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposJornadas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposJornadasController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposJornadas::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
