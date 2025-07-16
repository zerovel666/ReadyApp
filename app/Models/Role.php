<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        "name",
        "slug",
    ];

    protected $table = 'roles';

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class,'roles_users');
    }
}
