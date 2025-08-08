<?php

namespace App\Http\Services;

use App\Http\Repository\DamageNoteRepository;

class DamageNoteService extends BaseService
{
    public function __construct(DamageNoteRepository $damageNoteRepository) {
        parent::__construct($damageNoteRepository);
    }
}