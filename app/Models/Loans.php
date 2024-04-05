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
        'interest',
        'loan_date',
        'status',
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($loan) {
            // Hapus semua entri LoansPayments yang terkait
            LoansPayments::where('loan_id', $loan->loan_id)->delete();
        });
    }
}
