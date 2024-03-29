<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingStart extends Model
{
    protected $fillable = [
        'date',
        'start_time',
        'end_time'
    ];

    public function votingStarts()
    {
        return $this ->hasOne('App\Models\VotingStart');
    }
}
