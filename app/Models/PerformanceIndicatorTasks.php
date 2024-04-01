<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicatorTasks extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'task_id',
        'total_task_done',
        'evaluation',
        'description',
    ];
}
