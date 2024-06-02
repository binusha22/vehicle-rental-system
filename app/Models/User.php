<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable=[

            'fname',
            'lname',
            'email',
            'username',
            'password',
            'type',
            'mleave',
            'device_token',
            'status'
    ];
    use Notifiable;
}
