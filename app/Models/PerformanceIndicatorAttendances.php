<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicatorAttendances extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'month',
        'total_entry',
        'evaluation',
        'description',
    ];
}
