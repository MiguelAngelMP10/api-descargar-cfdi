<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Ret20Paises extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'ret_20_paises';
}
