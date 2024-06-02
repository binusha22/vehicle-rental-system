<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiclecategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'vcat',
        'brand',
        'model'
    ];
}
