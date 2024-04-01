<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'loan_id',
        'loan_amount',
        'method',
        'installments',
        'loan_date',
        'status',
    ];
}
