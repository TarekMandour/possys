<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->photo){
            $photo = $this->getPhoto();
        }else{
            $photo = "";
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $photo,
            'is_active' => $this->is_active,
            'city' => $this->city,
            'address' => $this->address,
            'location' => $this->location,
            'api_token' => $this->api_token,
        ];
    }
}
