<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable=[
'invoice_number' , 'vehicle_number' , 'vehicle_name' ,'customer_id' ,'customer_name'  , 'cus_id' , 'cus_passport',
'mobile' , 'vehicle_pickup_location' ,'reg_date','select_employee', 'start_date'  ,'end_date'  ,'  status','s_mileage','e_mileage','s_mileage','trip_range','uploadImage_url','fual','end_fual','advanced','amount','rest','agreedmile','additinalMile','flight_number','arrival_date','landing_time','wa_number','additonal_cost_km'
    ];
}
