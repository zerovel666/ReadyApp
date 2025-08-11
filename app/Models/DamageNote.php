<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DamageNote extends Model
{
    protected $fillable = [
        "car_id",
        "task_id",
        "check_list_item_id",
        "longitude",
        "latitude",
        "is_resolved",
    ];

    protected $table = 'damage_notes';

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function checkListItem(): BelongsTo
    {
        return $this->belongsTo(CheckList::class, 'check_list_item_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(DamageImage::class, 'damage_note_id', 'id');
    }
}
