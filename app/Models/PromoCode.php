<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoCode extends Model
{
    protected $fillable = [
        "code",
        "user_id",
        "expired_at",
        "percent",
        "count_use_limit",
        "is_global",
        "count_use"
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
