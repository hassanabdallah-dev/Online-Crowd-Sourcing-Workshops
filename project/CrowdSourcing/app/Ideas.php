<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $fillable = [
        'id',
        'participant_id',
        'workshop_id',
        'idea',
        'score',
        'taken'

    ];
}
