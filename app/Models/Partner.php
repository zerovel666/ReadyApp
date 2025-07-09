<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    
}
