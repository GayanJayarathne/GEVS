<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class party extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function parties()
    {
        return $this ->hasOne('App\Models\party');
    }
}
