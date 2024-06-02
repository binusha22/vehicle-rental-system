<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerPayment extends Model
{
    use HasFactory;

    protected $fillable=[

        'vnumber', 'vname', 'owner_name',  'phone_number', 'agreed_miledge',  'agreed_payment',  'liesence_renew_cost', 'liesence_renew_date', 'previous_mile', 'additional_mile', 'previous_pay_date','status'

    ];
    public $timestamps = false;
}
