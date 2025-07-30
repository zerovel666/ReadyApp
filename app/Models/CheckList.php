<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckList extends Model
{
    protected $fillable = [
        "task_id",
        "field_name",
        "order_no",
        "damaged",
        "cheking",
    ];

    protected $table = 'check_lists';

    public function task():BelongsTo
    {
        return $this->belongsTo(Task::class,'task_id','id');
    }
}
