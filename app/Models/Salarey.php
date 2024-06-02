<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salarey extends Model
{
    use HasFactory;

    protected $fillable=[
                'name','EmpnId','addDate','ot_hours','total_ot_paid','grant_leaves','salary'

    ];
}
