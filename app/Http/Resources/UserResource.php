<?php

namespace App\Http\Resources;

use App\Models\UserRule;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email ' => $this->email,
            'phone ' => $this->phone,
            'gender' => $this->gender,
            'profile_image' => $this->profile_image,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            // 'platform' => $this->platform,
            'userinfo' => $this->UserInfo,
        ];
        
        // return parent::toArray($request);
    }
}
