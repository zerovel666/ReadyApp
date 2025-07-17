<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    protected $table = 'car_models';

    protected $fillable = [
        'creator_id',
        'stamp_id',
        'body_id',
        'engine_id',
        'transmission_id',
        'engine_volume',
        'power',
        'seats',
        'doors',
        'fuel_tank_capacity',
        'weight',
        'height',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'creator_id', "id");
    }

    public function stamp(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'stamp_id', "id");
    }

    public function body(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'body_id', "id");
    }

    public function engine(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'engine_id', "id");
    }

    public function transmission(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'transmission_id', "id");
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, "model_id", "id");
    }
}
