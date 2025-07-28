<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentPosition extends Model
{
    protected $fillable = [
        "agent_id",
        "longitude",
        "latitude"  
    ];

    protected $table = 'agent_positions';

    public function agent():BelongsTo
    {
        return $this->belongsTo(AgentInfo::class,'agent_id','id');
    }
}
