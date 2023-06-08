<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CfdiClavesUnidades extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'cfdi_claves_unidades';
}
