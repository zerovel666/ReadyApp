<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TwoFactorToken extends Model
{
    protected $fillable = [
        "uuid",
        "email",
        "register_data",
        "two_factor_code",
        "code_expires_at",
        "active",
    ];

    protected $table = 'two_factor_tokens';

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->uuid = Str::uuid();
        });

    }
}
