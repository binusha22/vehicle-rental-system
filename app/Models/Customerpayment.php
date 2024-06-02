<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerpayment extends Model
{
    use HasFactory;

    protected $fillable=[
'invoice_number' , 'vehicle_number','customer_id' , 'customer_name' ,  'id_number' ,'passport_number', 'start_date' , 'end_date' ,'trip_amount', 'additional_milage' ,  'additional_milage_cost' , 'final_amount' , 'advanced','toPay' , 'payment_date'  ,'status','deposit','rest_of_deposit','damage_fee'

    ];
}
