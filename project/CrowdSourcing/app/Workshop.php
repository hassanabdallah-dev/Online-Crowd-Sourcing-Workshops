<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'key',
        'name',
        'location',
        'nbparticipants',
        'nbparticipantsmax',
        'active'

    ], $table ='workshop';
}
