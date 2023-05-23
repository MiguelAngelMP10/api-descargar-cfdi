<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class NominaTiposIncapacidades extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'nomina_tipos_incapacidades';
}
