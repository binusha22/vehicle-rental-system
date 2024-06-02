<?php

namespace App\Models;
use Illuminate\Http\Request;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class liecence_renew extends Model
{
    use HasFactory;
    protected $fillable=[
        'vehicle_id','brand','model','vehicle_number','renewed_date','expire_date','renew_cost'
    ];	
    
    
}
