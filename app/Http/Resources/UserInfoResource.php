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
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'dob' => $this->dob,
            'country'            => $this->country,
            'interests'          => $this->interests,
            'about_me'           => $this->about_me,
            'life_interests'     => $this->life_interests,
            'relationship_goals' => $this->relationship_goals,
            'life_style'         => $this->life_style,
            'job_title'          => $this->job_title,
            'company'            => $this->company,
            'school'             => $this->school,
            'created_at'         => (string) $this->created_at,
            'updated_at'         => (string) $this->updated_at,
            'user'               => $this->user,
            'media'              => $this->media,
        ];
        // return parent::toArray($request);
    }
}
