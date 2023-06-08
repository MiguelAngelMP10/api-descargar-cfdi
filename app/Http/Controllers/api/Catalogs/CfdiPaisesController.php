<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiPaises;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiPaisesController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiPaises::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
            'patron_codigo_postal',
            'patron_identidad_tributaria',
            'validacion_identidad_tributaria',
            'agrupaciones',
        ];
    }
}
