<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuRenew extends Model
{
    use HasFactory;
    protected $fillable=[
        'vehicle_id','brand','model','vehicle_number','renewed_date','expire_date'
    ];	
}
