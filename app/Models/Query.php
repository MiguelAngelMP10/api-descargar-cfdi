<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Query extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'rfc',
        'endPoint',
        'downloadType',
        'requestType',
        'dateTimePeriodStart',
        'dateTimePeriodEnd',
        'requestId',
        'numeroCFDIs',
        'documentType',
        'documentStatus',
        'complementoCfdi',
        'rfcMatches',
        'rfcOnBehalf',
        'uuid',
        'statusCode',
        'statusMessage',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
