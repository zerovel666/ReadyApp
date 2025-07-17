<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "detail_info",
        "email",
        "phone",
        "country_id",
        "address",
        "logo_path",
    ];

    protected $table = 'partners';

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function user(): HasMany
    {
        return $this->hasMany(User::class, "partner_id", "id");
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, "partner_id", "id");
    }
}
