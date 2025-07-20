<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        "active",
    ];

    protected $table = 'cars';

    public function model():BelongsTo
    {
        return $this->belongsTo(CarModel::class,"model_id","id");
    }

    public function partner():BelongsTo
    {
        return $this->belongsTo(Partner::class,"partner_id","id");
    }

    public function color():BelongsTo
    {
        return $this->belongsTo(Dicti::class,"color_id","id");
    }
}
