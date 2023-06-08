<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposNominas;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposNominasController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposNominas::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
