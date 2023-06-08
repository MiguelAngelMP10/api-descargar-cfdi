<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposRegimenes;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class NominaTiposRegimenesController extends Controller
{
    use DisableAuthorization;

    protected $model = NominaTiposRegimenes::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
