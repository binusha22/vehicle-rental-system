<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Svalues;

class Staks extends Model
{
    use HasFactory;
    
    protected $fillable=[
    'user_id','vname','vnumber','emp_name','date','status'   
    ];
     public $timestamps = false;

     public function svalues()
    {
        return $this->hasMany(Svalues::class, 'staks_id');
    }
}
