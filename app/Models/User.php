<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        "avatar"
    ];

    protected $table = 'users';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, "partner_id", "id");
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, "country_id", "id");
    }
}
