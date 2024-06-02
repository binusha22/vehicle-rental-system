<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replacedetails extends Model
{
    use HasFactory;

    protected $fillable=[

        'new_inv', 'old_inv' ,'cus_name' , 'cus_id' , 'passport' , 'reg_date' , 's_date',  'e_date'  ,'old_v_number' , 'new_v_number', 'trip_amount' ,'additional_cost_km' ,'rest_of_deposit' 

    ];
}
