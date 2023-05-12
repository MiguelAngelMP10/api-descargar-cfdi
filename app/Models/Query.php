<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Query extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function packeges(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
