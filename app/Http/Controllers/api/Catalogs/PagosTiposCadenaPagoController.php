<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\PagosTiposCadenaPago;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class PagosTiposCadenaPagoController extends Controller
{
    use DisableAuthorization;

    protected $model = PagosTiposCadenaPago::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
