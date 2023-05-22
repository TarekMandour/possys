<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;

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

        $ord = Order::where('order_id', $this->order_id)->latest('order_id')->first();
        return [
            'order_id' => $this->order_id,
            'branch' => json_decode($ord->branch)->name,
            'order_type' => $ord->order_type,
            'cash' => $ord->cash,
            'online' => $ord->online,
            'date' => $ord->sdate,
            'client_name' => json_decode($ord->client)->name,
            'client_phone' => json_decode($ord->client)->phone,
        ];
    }

}
