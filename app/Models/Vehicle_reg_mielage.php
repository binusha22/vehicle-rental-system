<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle_reg_mielage extends Model
{
    use HasFactory;
    protected $fillable=[
        'vehicle_reg_id' ,'vehicle_number','vehicle_name', 'mielage' 
    ];
}
