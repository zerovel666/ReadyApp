<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
