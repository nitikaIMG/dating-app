<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Explore extends Model
{
    use HasFactory;
    protected $table = 'explores';
    protected $fillable = ['name'];
    // protected $guarded = [];

    
     public function explores()
     {
         return $this->hasMany(ExploreUser::class,'explore_id');
     }


}

