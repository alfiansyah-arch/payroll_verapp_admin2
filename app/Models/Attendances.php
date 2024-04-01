<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'month',
        'date',
        'entry_time',
        'exit_time',
        'entry_photo',
        'exit_photo',
        'entry_location',
        'exit_location',
        'status',
    ];
}
