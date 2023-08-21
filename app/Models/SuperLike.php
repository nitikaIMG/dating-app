<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperLike extends Model
{
    use HasFactory;
    protected $table = 'super_likes';
    protected $fillable = [
        'sender_id',
        'super_like_user_id',
        'super_like_status'
    ];
}
