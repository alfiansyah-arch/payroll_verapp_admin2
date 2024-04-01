<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCalendarsColors extends Model
{
    use HasFactory;
    protected $fillable =[
        'color',
        'color_name',
        'color_information',
    ];
}
