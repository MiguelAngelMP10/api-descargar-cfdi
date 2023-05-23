<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40PatentesAduanales;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40PatentesAduanalesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40PatentesAduanales::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
