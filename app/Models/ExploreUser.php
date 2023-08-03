<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExploreUser extends Model
{
    use HasFactory;
    protected $tabel = 'explore_users';
    protected $fillable = [
        'explore_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exp()
    {
        return $this->belongsTo(Explore::class,'explore_id');
    }
}
