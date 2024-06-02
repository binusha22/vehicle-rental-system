<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carreplace extends Model
{
    use HasFactory;

    protected $fillable=[

        'invoice' ,'customer_name' , 'id_number', 'passport','deposit','vehicle_name','vehicle_number','old_bookdate','reason' , 'status'

    ];

    
}
