<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceMotivosTraslado;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceMotivosTrasladoController extends Controller
{
    use DisableAuthorization;

    protected $model = CceMotivosTraslado::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
