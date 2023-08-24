<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyTerms extends Model
{
    use HasFactory;
    protected $table = 'privacy_terms';
    protected $fillable = [
        'name',
        'privacy_page',
        'status'
    ];
}
