<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    protected $fillable = [
        "model_id",
        "partner_id",
        "vin",
        "license_plate",
        "color_id",
        "mileage",
        "last_inspection_date",
        "date_release",
        "rating",
        "status",
        "amount",
        "currency_id"
    ];

    protected $table = 'cars';

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, "model_id", "id");
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, "partner_id", "id");
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, "color_id", "id");
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, "user_id", "id");
    }
    public function location():HasOne
    {
        return $this->hasOne(CarLocation::class,"car_id","id");
    }
    public function damage(): HasOne
    {
        return $this->hasOne(DamageNote::class, 'car_id', 'id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(Dicti::class,'currency_id','id');
    }
}
