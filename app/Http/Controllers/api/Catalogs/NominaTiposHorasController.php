<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposHoras;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposHorasController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposHoras::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
