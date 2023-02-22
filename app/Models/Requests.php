<?php

namespace App\Models;

use App\Http\Resources\RequestResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['sender_id','receiver_id','status'];

    public function format()
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id ?? '',
            'receiver_id' => $this->receiver_id ?? '',
            'status' => $this->status ?? '',
        ];
    }
    
    # user model 
    public function users()
    {
        return $this->belongsTo(User::class,'id');
    }
}
