<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20TiposPagoRetencion;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20TiposPagoRetencionController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20TiposPagoRetencion::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'tipo_impuesto',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
