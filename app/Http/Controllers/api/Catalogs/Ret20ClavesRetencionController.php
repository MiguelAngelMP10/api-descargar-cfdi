<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20ClavesRetencion;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20ClavesRetencionController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20ClavesRetencion::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'nombre_complemento',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
