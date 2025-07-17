<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        "car_id",
        "address",
        "latitude",
        "longitude",
    ];

    protected $table = 'car_locations';

    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class,"car_id","id");
    }
}
