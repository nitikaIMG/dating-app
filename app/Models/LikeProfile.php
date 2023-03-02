<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeProfile extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'liked_user_id', 'like_status'];

    # user model 
    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
