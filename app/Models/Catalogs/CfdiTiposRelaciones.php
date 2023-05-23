<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CfdiTiposRelaciones extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'cfdi_tipos_relaciones';
}
