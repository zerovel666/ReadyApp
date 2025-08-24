<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
    protected $fillable = [
        "car_equipment_id",
        "filepath"
    ];

    protected $table = 'car_images';

    public function carEquipment():BelongsTo
    {
        return $this->belongsTo(CarEquipment::class,"car_equipment_id","id");
    }
    
}
