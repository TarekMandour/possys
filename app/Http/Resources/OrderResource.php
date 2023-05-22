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

        $Settings = Setting::find(1);

        $inv_total = $this->total_sub + $this->total_tax;

        $generatedString = [
            $this->toString($Settings->title, '1'),
            $this->toString($Settings->tax_num, '2'),
            $this->toString($this->created_at, '3'),
            $this->toString($inv_total, '4'),
            $this->toString($this->total_tax, '5'),

        ];
        
        $products = array();

        $total_product = 0;
        $total_tax = 0;
        $total_discount = 0;

        $total_sub = 0;
        $total_tax = 0;
        $total = 0;
        $is_discount = 0;
        $discount_price = 0;

        foreach ($orders as $key => $ord) {

            $attributes = (object)[];
            $attPrice = 0;
            foreach (PostAttribute::where('itm_code', $ord->itm_code)->get() as $key => $att) {
                if ($att->id == $ord->attributes) {
                    $attributes = $att;
                    $attPrice = $att->attprice;
                }
            }


            $arr_additional = array();
            $addiPrice = 0;
            $additional = json_decode($ord->additionals);
            foreach (PostAdditional::where('itm_code', $ord->itm_code)->get() as $key => $addi) {
                foreach ((array) $additional as $key => $additi) {
                    if ($addi->id == $additi) {
                        $arr_additional[] = $addi;
                        $addiPrice += $addi->addprice;
                    }
                }
            }

            $pro_price_before_tax = (($ord->price_selling + $attPrice) * $ord->qty) + $addiPrice ;
            $pro_tax = 0 ;

            $total_product = round($total_product + $pro_price_before_tax, 2);
                if ($ord->is_tax == 1) {
                    $pro_tax = ((($ord->price_selling + $attPrice) * $ord->qty) + $addiPrice) * ($Settings->tax / 100);
                    $pre_price = $pro_price_before_tax ;
                    $pre_discount = $pre_price * ( $ord->discount / 100);
                    $total_tax = round($total_tax + ($pre_price - $pre_discount) * ($Settings->tax / 100), 2);
                }
                
            $pro_price_after_tax = $pro_price_before_tax + $pro_tax ;

            $products[] = [
                'itm_code' => $ord->itm_code,
                'name' => json_decode($ord->product)->title,
                'qty' => $ord->qty,
                'price_selling' => $ord->price_selling,
                'is_tax' => $ord->is_tax,
                'unit_id' => $ord->unit_id,
                'unit_title' => $ord->unit_title,
                'expiry_date' => $ord->expiry_date,
                'attributes' => $attributes,
                'arr_additional' => $arr_additional,
                'price_before_tax' => $pro_price_before_tax,
                'tax' => $pro_tax,
                'price_after_tax' => $pro_price_after_tax
            ];
        }     
        
        $total_discount = round(( $ord->discount / 100) * $total_product, 2);

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
            'total_product' => $total_product,
            'total_discount' => $total_discount,
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
            'client_name' => json_decode($this->client)->name,
            'client_phone' => json_decode($this->client)->phone,
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
