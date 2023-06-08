<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceClavesPedimentos;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class CceClavesPedimentosController extends Controller
{
    use DisableAuthorization;

    protected $model = CceClavesPedimentos::class;

    public function filterableBy(): array
    {
        return [
            'id',
            'texto',
        ];
    }
}
