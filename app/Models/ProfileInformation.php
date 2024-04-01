<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileInformation extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'NIK',
        'full_name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'blood',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'religion',
        'marital_status',
        'citizenship',
    ];
}
