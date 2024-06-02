<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookVehicle extends Model
{
    use HasFactory;

    protected $fillable=[
            'vid' ,'startdate' , 'enddate'

    ];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vid', 'id');
    }
    public $timestamps = false;
}
