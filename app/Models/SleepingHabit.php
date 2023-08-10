<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SleepingHabit extends Model
{
    use HasFactory;
    protected $table = 'sleeping_habits';
    protected $fillable = [
        'name',
        'status'
    ];
}