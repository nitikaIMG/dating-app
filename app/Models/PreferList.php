<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferList extends Model
{
    use HasFactory;
    protected $table = 'prefer_list';
    protected $fillable = [
        'user_id',
        'age_status',
        'first_age',
        'second_age',
        'distance_status',
        'first_distance',
        'second_distance',
        'show_me_to',
    ];
}
