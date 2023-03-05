<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'address' => $this->address,
            'phone' => $this->phone,
            'sales_name' => $this->sales_name,
            'phone2' => $this->phone2,
            'email' => $this->email,
            'num' => $this->num,
            'is_active' => $this->is_active,
            'tax_number' => $this->tax_number,

        ];
    }
}
