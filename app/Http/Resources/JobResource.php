<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'title' => $this->title,
            'logo' => $this->logo,
            'tags' => $this->tags,
            'location' => $this->location,
            'company' => $this->company,
            'Job_email' => $this->email,
            'Job_website' => $this->website,
            'description' => $this->description,
        ];
    }
}
