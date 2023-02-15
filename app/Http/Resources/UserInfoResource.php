<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     'id' => $this->id,
        //     'user_id' => $this->user_id,
        //     'dob' => $this->dob,
        //     'country' => $this->country,
        //     'interests' => $this->interests,
        //     'photos' => $this->photos,
        //     'created_at' => (string) $this->created_at,
        //     'updated_at' => (string) $this->updated_at,
        //     'user' => $this->user,
        // ];
        return parent::toArray($request);
    }
}
