<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $table = 'api_tokens';

    protected $fillable = [
        'token',
        'username',
        'expires_at',
    ];

    protected $dates = [
        'expires_at',
    ];
}
