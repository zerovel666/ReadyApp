<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarModel extends Model
{
    protected $table = 'car_models';

    protected $fillable = [
        'creator',
        'stamp',
        'body',
        'engine',
        'transmission',
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
        return $this->belongsTo(Dicti::class, 'creator');
    }

    public function stamp(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'stamp');
    }

    public function body(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'body');
    }

    public function engine(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'engine');
    }

    public function transmission(): BelongsTo
    {
        return $this->belongsTo(Dicti::class, 'transmission');
    }
}
