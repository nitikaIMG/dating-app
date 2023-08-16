<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passion extends Model
{
    use HasFactory;
    protected $table = 'passions';
    protected $fillable = [
        'name',
        'status'
    ];
}
