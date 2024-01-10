<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constituency extends Model
{
    protected $fillable = [
        'name'
    ];

    public function constituencies()
    {
        return $this ->hasOne('App\Models\Constituency');
    }
}
