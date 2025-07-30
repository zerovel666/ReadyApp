<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        "user_id",
        "agent_id",
        "address_a",
        "address_b",
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
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }



    public function checkList(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'check_list_id', 'id');
    }
}
