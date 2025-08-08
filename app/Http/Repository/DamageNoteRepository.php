<?php

namespace App\Http\Repository;

use App\Models\DamageNote;

class DamageNoteRepository extends BaseRepository
{
    public function __construct(DamageNote $damageNote) {
        parent::__construct($damageNote);
    }
}