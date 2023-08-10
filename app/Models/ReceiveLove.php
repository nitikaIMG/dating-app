<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveLove extends Model
{
    use HasFactory;
    protected $table = 'receive_love';
    protected $fillable = [
        'name',
        'status'
    ];
}
