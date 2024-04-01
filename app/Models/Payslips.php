<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslips extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'date',
        'basic_salary',
        'meal_allowance',
        'transportation_money',
        'family_allowance',
        'position_allowance',
        'overtime_pay',
        'commission_money',
        'description',
        'status',
    ];
}
