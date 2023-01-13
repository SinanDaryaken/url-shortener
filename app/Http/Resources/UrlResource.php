<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'user' => new UserResource($this->user),
            'name' => $this->name,
            'link' => $this->link,
            'slug' => $this->slug
        ];
    }
}
