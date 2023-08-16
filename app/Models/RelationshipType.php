<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationshipType extends Model
{
    use HasFactory;
    protected $table = 'relationship_types';
    protected $fillable = [
        'name',
        'status'
    ];
}
