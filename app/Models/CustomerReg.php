<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReg extends Model
{
    use HasFactory;
    protected $fillable=[
        'fname',
        'lname',
        'dob' ,
        'idnumber',
            'passportnumber',
            'liecencenumber',
            'phonenumber',
            'address',
            'vip_or_nonvip',
            'regDate',
            'address_op',
            'mobile_op',
            'whatsappnumber',
            'deposit',
            'current_deposit'
    ];
}
