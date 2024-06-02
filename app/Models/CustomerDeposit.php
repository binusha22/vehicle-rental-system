<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDeposit extends Model
{
    use HasFactory;

protected $fillable=[
'cus_id' , 'invoice', 'name'  ,'id_number','passport', 'deposit', 'current_deposit'

]; 

    
}
