<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Periodicidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40PeriodicidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40Periodicidades::class;

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
