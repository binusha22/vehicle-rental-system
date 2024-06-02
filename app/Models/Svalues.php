<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Staks;

class Svalues extends Model
{
    use HasFactory;

    protected $fillable=[
        'staks_id','type','checked_value','status'  
    ];
     public $timestamps = false;

     public function staks()
    {
        return $this->belongsTo(Staks::class, 'staks_id');
    }
}
