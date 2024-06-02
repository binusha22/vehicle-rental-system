<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable=[
           'vcat','brand' ,  'model' ,  'vehicle_number' 

    ];
    public function bookings()
    {
        return $this->hasMany(BookVehicle::class, 'vid', 'id');
    }
}
