<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dicti extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "parent_id",
        "char_value",
        "num_value",
        "json_value",
        "constant",
        "constant1",
        "constant2",
    ];

    protected $table = 'dictis';

        public function children(): HasMany
    {
        return $this->hasMany(Dicti::class, "parent_id", "id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, "parent_id", "id");
    }
}
