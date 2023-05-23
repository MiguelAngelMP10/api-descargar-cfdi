<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CfdiMetodosPago extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'cfdi_metodos_pago';
}