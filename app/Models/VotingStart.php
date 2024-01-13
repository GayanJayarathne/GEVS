<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingStart extends Model
{
    protected $fillable = [
        'start_date',
        'start_time',
        'end_date',
        'end_time'
    ];
}
