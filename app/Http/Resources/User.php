<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mastodon' => $this->mastodon,
            'sendegate' => str_replace('@', '', $this->sendegate),
            'avatar' => $this->avatar,
            'search' => $this->search,
            'offer' => $this->offer,
            'projects' => Project::collection($this->projects),
        ];
    }
}
