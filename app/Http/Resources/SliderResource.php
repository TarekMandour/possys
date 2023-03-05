<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'title1' => $this->title1,
            'title2' => $this->title2,
            'content' => $this->content,
            'sort' => $this->sort,
            'photo' => $this->photo,
            'logo' => $this->logo,
            'product' => $this->Product?$this->Product->title:"",

        ];
    }
}
