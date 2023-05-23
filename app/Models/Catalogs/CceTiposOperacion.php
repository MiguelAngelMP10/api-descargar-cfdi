<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CceTiposOperacion extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'cce_tipos_operacion';
}
