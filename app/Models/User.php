<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        "email",
        "full_name",
        "country_id",
        "partner_id",
        "telegram_user_id",
        "uniq_id_people",
        "phone",
        "active",
    ];

    protected $table = 'users';

    protected $hidden = [
        "password",
        "remember_token",
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
