<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiTiposFactores;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CfdiTiposFactoresController extends Controller
{
    use DisableAuthorization;

    protected $model = CfdiTiposFactores::class;

    public function filterableBy(): array
    {
        return [
            'id',
        ];
    }
}
