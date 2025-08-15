<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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
        "active",
        "order_no"
    ];

    protected $table = 'dictis';

    protected static function booted()
    {
        static::addGlobalScope('available', function (Builder $builder) {
            $user = Auth::user();
            if (!$user || !$user->roles()->where("slug", "admin")->exists()) {
                $builder->where('active', true);
            }
        });
    }
    public function children(): HasMany
    {
        return $this->hasMany(Dicti::class, "parent_id", "id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, "parent_id", "id");
    }
}
