<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAvaorUna extends Model
{
    use HasFactory;
    protected $fillable=[
        'vehicle_number'	,'vehicle_name'	,'vehicle_status'	,'reason','booking_status',	'book_date','release_date'
    ];
}
