<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ownerpaydetails extends Model
{
    use HasFactory;

    protected $fillable=[

        'vnumber', 'vname', 'owner_name',  'phone_number', 'agreed_miledge',  'agreed_payment',  'liesence_renew_cost', 'liesence_renew_date','maintain_cost','new_mile','monthly_amount', 'previous_mile', 'additional_mile','km_cost_additi_mile','total_additio_cost', 'previous_pay_date'   

    ];
    public $timestamps = false;
}
