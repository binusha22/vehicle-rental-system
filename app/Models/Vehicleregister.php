<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicleregister extends Model
{
    use HasFactory;
    protected $fillable=[
        'vcat','brand',	'model','year','vehicle_number'	,'mielage',	'newMiledge','lice_start'	,'lice_end'	,'insu_start','insu_end','owner_type','owner_fname'	,'owner_id','owner_phone_number','registerdate','chasis','engine_number','vehicle_color','address'
    ];
}
