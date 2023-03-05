<?php

namespace App\Http\Resources;
use App\Models\Attribute;
use App\Models\PostAttribute;
use App\Models\PostAdditional;
use App\Models\Order;
use App\Models\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class AllOrderResource extends JsonResource
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
            'order_id' => $this[0]->order_id,
            'branch' => json_decode($this[0]->branch)->name,
            'order_type' => $this[0]->order_type,
            'total_tax' => $this[0]->total_tax,
            'total_sub' => $this[0]->total_sub,
            'date' => $this[0]->sdate,
            'client_name' => json_decode($this[0]->client)->name,
            'client_phone' => json_decode($this[0]->client)->phone,
        ];
    }

}
