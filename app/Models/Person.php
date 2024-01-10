<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'voterId',
        'fullName',
        'dateOfBirth',
        'password',
        'constituencyId',
        'uvcCodeId'
    ];
}
