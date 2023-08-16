<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationshipGoals extends Model
{
    use HasFactory;
    protected $table = 'relationship_goals';
    protected $fillable = [
        'name',
        'status'
    ];
}
