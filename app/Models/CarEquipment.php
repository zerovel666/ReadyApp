<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class CarEquipment extends Model
{
    protected $fillable = [
        "car_model_id",
        "active",
        "color_id",
        "amount",
        "currency_id",
    ];

    protected static function booted()
    {
        static::addGlobalScope('available', function (Builder $builder) {
            $user = Auth::user();
            if (!$user || !$user->roles()->where("slug", "admin")->exists()) {
                $builder->where('active', true);
            }
        });
    }
    public function color(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, "color_id", "id");
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, "car_model_id", "id");
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'currency_id', 'id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'car_equipment_id', 'id');
    }
    public function carImages(): HasMany
    {
        return $this->hasMany(CarImage::class, "car_equipment_id", "id");
    }
}
