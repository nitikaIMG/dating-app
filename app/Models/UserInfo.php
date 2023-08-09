<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Explore;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_info';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    // protected $casts = [
    //     'dob' => 'date:d-m-Y',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function explores()
    {
        return $this->belongsToMany(Explore::class,'explore_id');
    }
}
