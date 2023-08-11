<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    use HasFactory;
    protected $table = 'blockusers';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'blocked_to');
    }
}
