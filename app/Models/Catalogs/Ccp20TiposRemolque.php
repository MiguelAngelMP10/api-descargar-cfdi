<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Ccp20TiposRemolque extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'ccp_20_tipos_remolque';
}
