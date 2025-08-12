<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        "car_id",
        "user_id",
        "agent_id",
        "start_date",
        "end_date",
        "status",
        "notified",
        "longitude",
        "latitude"  
    ];

    protected $table = 'bookings';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!in_array($model->status, ["pending", "approved", "completed", "canceled"])) {
                throw new \Exception("Invalid booking status", 400);
            }
        });
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, "car_id", "id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function task(): HasOne
    {
        return $this->hasOne(Task::class,'booking_id','id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(AgentInfo::class,'agent_id','id');
    }
}
