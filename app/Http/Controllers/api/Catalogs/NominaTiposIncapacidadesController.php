<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposIncapacidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposIncapacidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposIncapacidades::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
