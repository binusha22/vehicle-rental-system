<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logindata extends Model
{
    use HasFactory;

    protected $fillable=[

        'user_id',
        'fname',
        'lname',
        'email',
        'username',
        'type',
        'logintime',
        'loginstatus'
        
];
}
