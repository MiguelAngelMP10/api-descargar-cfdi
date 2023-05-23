<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CceFraccionesArancelarias extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'cce_fracciones_arancelarias';
}
