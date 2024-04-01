<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleStatus extends Model
{
    use HasFactory;
    protected $table ='role_status';
    protected $fillable =[
        'role_status_name',
    ];
}
