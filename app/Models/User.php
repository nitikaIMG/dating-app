<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    # User may have one information record
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function getStatusTextAttribute()
    {
        $status = [
            0 => 'blocked',
            1 => 'active',
        ];

        return $status[$this->status];
    }

    public function getNameAttribute()
    {
        return $this->last_name
            ? $this->first_name . " " . $this->last_name
            : $this->first_name;
    }

    public function userformat()
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone ?? '',
        ];
    }

    public function format()
    {

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name ?? '',
            'phone' => $this->phone ?? '',
            'email' => $this->email ?? '',
            'dob'   => $this->dob ?? null,
            'country' => $this->country,
            'interests' => $this->interests,
            'gender' => $this->gender,
            'email_verified_at' => $this->email_verified_at,
            'refer_code' => $this->refer_code,
            // 'otp'=>$this->otp,
        ];
    }

    public function formatdata()
    {
        return [
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name ?? '',
            'phone'             => $this->phone ?? '',
            'email'             => $this->email ?? '',
            'dob'               => $this->dob ?? null,
            'country'           => $this->country,
            'interests'         => $this->interests,
            'gender'            => $this->gender,
            'email_verified_at' => $this->email_verified_at,
            'refer_code'        => $this->refer_code,
            'created_at'        => $this->created_at->format('d-m-Y'),
            'active_device_id'  => $this->active_device_id,
            'profile_image'     => $this->profile_image,
            'phone '            => $this->phone,
            'profile_image'     => $this->profile_image,
            // 'userinfo'         => $this->UserInfo,
        ];
    }


    public function isBlocked()
    {
        return $this->status === 0;
    }

    public function devices()
    {
        return $this->hasMany(UserDevice::class, 'user_id');
    }


    //aachuki

    public function UserInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    # request model 
    public function requests()
    {
        return $this->hasMany(Requests::class, 'receiver_id');
    }

    # request model 
    public function likeprofile()
    {
        return $this->hasMany(Requests::class, 'liked_user_id');
    }

    #media model
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    # blockuser model
    public function blockuser()
    {
        return $this->belongsTo(BlockUser::class, 'blocked_by');
    }
}
