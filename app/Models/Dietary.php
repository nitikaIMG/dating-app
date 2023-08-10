<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dietary extends Model
{
    use HasFactory;
    protected $table = 'dietary_preference';
    protected $fillable = [
        'name',
        'status'
    ];
}