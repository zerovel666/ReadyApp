<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
