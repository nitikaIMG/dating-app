<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zodiac extends Model
{
    use HasFactory;
    protected $table = 'zodiacs';
    protected $fillable = [
        'name',
        'status'
    ];
}
