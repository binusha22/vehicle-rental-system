<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicecost extends Model
{
    use HasFactory;
    protected $fillable=[
        'vnumber' ,'vname','date','cost' ,'des','status'
    ];
}
