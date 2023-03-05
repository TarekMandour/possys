<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'whywedo' => $this->whywedo,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'photo' => $this->getPhoto(),
            'photo2' => $this->getPhoto2(),
            'photo3' => $this->getPhoto3(),
            'photo4' => $this->getPhoto4(),

        ];
    }
}
