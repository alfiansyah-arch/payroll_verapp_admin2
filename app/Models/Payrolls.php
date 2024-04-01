<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payrolls extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'basic_salary',
        'meal_allowance',
        'transportation_money',
        'family_allowance',
        'positional_allowance',
    ];
}
