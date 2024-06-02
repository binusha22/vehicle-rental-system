<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
protected $fillable=[
'user_id', 'name', 'fromDate' , 'toDate',  'leaves' , 'grantedLeaves' ,  'restLeaves' , 'reason','req_leaves','req_date','status'
];
    
}
