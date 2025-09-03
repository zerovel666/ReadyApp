<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportRequest extends Model
{
    protected $fillable = [
        "user_id",
        "manager_id",
        "description",
        "booking_id",
        "resolved",
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function manager():BelongsTo
    {
        return $this->belongsTo(User::class,'manager_id','id');
    }

    public function booking():BelongsTo
    {
        return $this->belongsTo(Booking::class,'booking_id','id');
    }
}
