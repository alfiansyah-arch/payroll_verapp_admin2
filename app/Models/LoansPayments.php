<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoansPayments extends Model
{
    use HasFactory;
    protected $fillable =[
        'payment_id',
        'loan_id',
        'installments',
        'total_loan',
        'payment_per_installments',
        'status',
        'due_date',
    ];
}
