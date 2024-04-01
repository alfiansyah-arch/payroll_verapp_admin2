<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCalendars extends Model
{
    use HasFactory;
    protected $fillable =[
        'kegiatan',
        'from_date',
        'to_date',
        'color',
    ];
}
