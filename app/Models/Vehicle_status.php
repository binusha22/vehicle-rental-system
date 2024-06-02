<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle_status extends Model
{
    use HasFactory;
    protected $fillable=[
        'vehicle_id',	'vehicle_name'	,'vehicle_number'	,'out_mileage'	,'in_mileage'	,'trip_mileage'	,'out_date'	,'in_date'	,'reason'	
    ];
}
