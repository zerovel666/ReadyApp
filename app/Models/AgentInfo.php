<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentInfo extends Model
{
    protected $fillable = [
        "user_id",
        "status_id",
        "schedule_work_id",
        "count_сompleted_tasks",
        "rating",
    ];

    protected $table = 'agent_infos';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'status_id', 'id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'schedule_work_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(AgentLocation::class, 'agent_id', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'agent_id', 'id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class,'agent_id','id');
    }
}
