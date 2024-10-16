<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'url' => $this->myurl(),
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo_path('small'),
            'errors' => [],
            'submitted' => false,
        ];
    }
}
