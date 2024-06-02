<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',	'name'	,'in_date',	'out_date'	,'in_time'	,'out_time'	,'ot','desc','work_hours'	,'status'
    ];
}
