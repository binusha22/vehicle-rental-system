<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashBoardvehicle extends Model
{
    use HasFactory;
    protected $fillable=[
        'vname','vnumber' ,'current_status','time' ,'date'
    ];
    

    public $timestamps = false;
}
