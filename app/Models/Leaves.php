<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'from_date',
        'to_date',
        'reason',
        'picture',
        'status',
    ];
}
