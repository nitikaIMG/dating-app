<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table='usersdetails';
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'dob',
        'gender',
        'interests',
        'photos', 
        'deleted_at', 
    ];
}
