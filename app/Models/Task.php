<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        "user_id",
        "agent_id",
        "car_id",
        "type_id",
        "booking_id",
        "status_id",
        "longitude_a",
        "latitude_a",
        "longitude_b",
        "latitude_b",
        "date_time_complete",
        "check_list_id",
        "description",
    ];

    protected $table = 'tasks';

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(AgentInfo::class, 'agent_id', 'id');
    }

    public function checkList(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'check_list_id', 'id');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class,'car_id','id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class,'booking_id','id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Dicti::class,'type_id','id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Dicti::class,'status_id','id');
    }
}
