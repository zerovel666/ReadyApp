<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dicti extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "parent_id",
        "char_value",
        "num_value",
        "json_value",
        "constant",
        "constant1",
        "constant2",
    ];

    protected $table = 'dictis';
}
