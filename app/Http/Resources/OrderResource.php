<?php

namespace App\Http\Resources;
use App\Models\Attribute;
use App\Models\PostAttribute;
use App\Models\PostAdditional;
use App\Models\Order;
use App\Models\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $orders = Order::where('order_id', $this->order_id)->get();

        $query['setting'] = Setting::find(1);

        $inv_total = $this->total_sub + $this->total_tax;

        $generatedString = [
            $this->toString($query['setting']->title, '1'),
            $this->toString($query['setting']->tax_num, '2'),
            $this->toString($this->created_at, '3'),
            $this->toString($inv_total, '4'),
            $this->toString($this->total_tax, '5'),

        ];
        
        $products = array();
        foreach ($orders as $key => $ord) {

            $attributes = 0;
            foreach (PostAttribute::where('itm_code', $ord->itm_code)->get() as $key => $att) {
                if ($att->id == $ord->attributes) {
                    $attributes = $att;
                }
            }


            $arr_additional = array();
            $additional = json_decode($ord->additionals);
            foreach (PostAdditional::where('itm_code', $ord->itm_code)->get() as $key => $addi) {
                foreach ((array) $additional as $key => $additi) {
                    if ($addi->id == $additi) {
                        $arr_additional[] = $addi;
                    }
                }
            }

            $products[] = [
                'itm_code' => $this->itm_code,
                'name' => json_decode($ord->product)->title,
                'qty' => $this->qty,
                'price_selling' => $this->price_selling,
                'is_tax' => $this->is_tax,
                'unit_id' => $this->unit_id,
                'unit_title' => $this->unit_title,
                'expiry_date' => $this->expiry_date,
                'attributes' => $attributes,
                'arr_additional' => $arr_additional
            ];
        }
        

        if($this->order_type == 1) {
            $order_type = 'مشتريات';
        }else {
            $order_type = 'مبيعات';
        } 

        return [
            'id' => $this->id,
            'tax_setting' => $this->tax_setting,
            'qtcode' => $this->toBase64($generatedString),
            'order_id' => $this->order_id,
            'order_type' => $order_type ,
            'order_return' => $this->order_return,
            'total_sub' => $this->total_sub,
            'total_tax' => $this->total_tax,
            'cash' => $this->cash,
            'online' => $this->online,
            'is_discount' => $this->is_discount,
            'discount' => $this->discount,
            'discount_title' => $this->discount_title,
            'discount_price' => $this->discount_price,
            'branch_id' => $this->branch_id,
            'branch' => json_decode($this->branch)->name,
            'client_id' => $this->client_id,
            'client'  => $this->client,
            'sdate' => $this->sdate,
            'add_by_id' => $this->add_by_id,
            'add_by_name' => $this->add_by_name,
            'products' => $products,
        ];
    }

    public function toBase64($value): string
    {
        return base64_encode($this->toTLV($value));
    }

    public function toTLV($value): string
    {
        return implode('', $value);
    }

    public function toString($value, $tag)
    {
        $value = (string)$value;

        return $this->toHex($tag) . $this->toHex($this->getLength($value)) . ($value);
    }

    protected function toHex($value)
    {
        return pack("H*", sprintf("%02X", $value));
    }

    public function getLength($value)
    {
        return strlen($value);
    }
}
