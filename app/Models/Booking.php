<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        "car_id",
        "user_id",
        "start_date",
        "end_date",
        "status",
        "notified",
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
}
