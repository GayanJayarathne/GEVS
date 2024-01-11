<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'party_id',
        'constituency_id',
        'votes',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function updateVotes(array $data)
    {
        // Update the votes and any other fields as needed
        $this->update([
            'name'  => $data['name'],
            'votes' => $data['votes'],
        ]);
    }
}
