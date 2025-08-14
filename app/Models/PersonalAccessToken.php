<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Support\Str;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
        'refresh_token',
        'expires_at_refresh_token'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->refresh_token)) {
                $model->refresh_token = hash('sha256', Str::random(64));
            }
            if (empty($model->expires_at_refresh_token)) {
                $model->expires_at_refresh_token = now()->addDays(30);
            }
        });
    }
}
