<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TwoFactorToken extends Model
{
    protected $fillable = [
        "email",
        "register_data",
        "two_factor_code",
        "code_expires_at",
        "active",
        "telegram_user_id",
        "uuid"
    ];

    protected $table = 'two_factor_tokens';

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->two_factor_code = Str::random(6);
            $model->code_expires_at = now()->addMinutes(10);
            $model->uuid = Str::uuid();
        });

    }
}
