<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'contact_us';
    protected $fillable = [
        'user_id',
        'admin',
        'email',
        'msg_for_admin',
        'reply_from_admin',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
