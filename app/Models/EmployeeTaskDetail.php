<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTaskDetail extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'task_id',
        'task_title',
        'task_description',
        'no_task',
        'date_start',
        'date_end',
        'status',
        'attachment',
    ];
}
