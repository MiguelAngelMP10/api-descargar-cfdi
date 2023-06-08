<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Ccp20ProductosServicios extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'ccp_20_productos_servicios';
}
