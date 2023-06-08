<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class PagosTiposCadenaPago extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $connection = 'sqlite_catalogs';
    protected $table = 'pagos_tipos_cadena_pago';
}
