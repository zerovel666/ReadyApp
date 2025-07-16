<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        "parent_countries_id",
        "name",
    ];

    protected $table = 'countries';

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class, "country_id", "id");
    }

    public function children(): HasMany
    {
        return $this->hasMany(Country::class, "parent_countries_id", "id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Country::class, "parent_countries_id", "id");
    }

    public function country(): HasMany
    {
        return $this->hasMany(Country::class, "country_id", "id");
    }
}
