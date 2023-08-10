<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationStyle extends Model
{
    use HasFactory;
    protected $table = 'communication_styles';
    protected $fillable = [
        'name',
        'status'
    ];

}
