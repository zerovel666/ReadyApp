<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DamageImage extends Model
{
    protected $fillable = [
        "damage_note_id",
        "filepath"
    ];

    protected $table = 'damage_images';

    public function damage():BelongsTo
    {
        return $this->belongsTo(DamageNote::class,'damage_note_id','id');
    }
}
