<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
