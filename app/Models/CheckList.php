<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function children():HasMany
    {
        return $this->hasMany(CheckList::class,'parent_id','id');
    }

    public function damage(): HasOne
    {
        return $this->hasOne(DamageNote::class, 'check_list_item_id', 'id');
    }
}
