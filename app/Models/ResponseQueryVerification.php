<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseQueryVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'query_id',
        'statusCode',
        'statusMessage',
        'statusRequestMessage',
        'statusRequestName',
        'statusRequestEntryIndex',
        'codeRequestValue',
        'codeRequestName',
        'codeRequestMessage',
    ];
}
