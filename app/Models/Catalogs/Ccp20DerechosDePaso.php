<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Ccp20DerechosDePaso extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'ccp_20_derechos_de_paso';
}
