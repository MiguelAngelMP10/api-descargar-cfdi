<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40FormasPago;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Cfdi40FormasPagoController extends Controller
{
    use DisableAuthorization;

    protected $model = Cfdi40FormasPago::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'es_bancarizado',
            'requiere_numero_operacion',
            'permite_banco_ordenante_rfc',
            'permite_cuenta_ordenante',
            'patron_cuenta_ordenante',
            'permite_banco_beneficiario_rfc',
            'permite_cuenta_beneficiario',
            'patron_cuenta_beneficiario',
            'permite_tipo_cadena_pago',
            'requiere_banco_ordenante_nombre_ext',
            'vigencia_desde',
            'vigencia_hasta',
        ];
    }
}
