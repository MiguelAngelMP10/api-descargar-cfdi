<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20TiposDividendosUtilidades;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class Ret20TiposDividendosUtilidadesController extends Controller
{
    use DisableAuthorization;

    protected $model = Ret20TiposDividendosUtilidades::class;

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
