<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Meses;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40MesesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Meses::class;

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
