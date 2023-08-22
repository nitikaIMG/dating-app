<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;
    protected $table = 'subscription_users';
    protected $fillable = [
        'user_id',
        'subscription_id',
        'months',
        'free_boost_per_month',
        'free_super_like',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionusers()
    {
        return $this->hasMany(SubscriptionPlan::class,'subscription_id');
    }

}
