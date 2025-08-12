<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
    protected $fillable = [
        "model_id",
        "filepath"
    ];

    protected $table = 'car_images';

    public function model():BelongsTo
    {
        return $this->belongsTo(CarModel::class,"model_id","id");
    }
    
}
