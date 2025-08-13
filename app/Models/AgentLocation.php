<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentLocation extends Model
{
    protected $fillable = [
        "agent_id",
        "longitude",
        "latitude"  
    ];

    protected $table = 'agent_locations';

    public function agent():BelongsTo
    {
        return $this->belongsTo(AgentInfo::class,'agent_id','id');
    }
}
