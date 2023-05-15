<?php

namespace App\Http\Resources;
use App\Models\Attribute;
use App\Models\PostAttribute;
use App\Models\PostAdditional;
use App\Models\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pro = Post::where('itm_code', $this->itm_code)->get()->first();

        $attributes = (object)[];
        foreach (PostAttribute::where('itm_code', $this->itm_code)->get() as $key => $att) {
            if ($att->id == $this->attributes) {
                $attributes = $att;
            }
        }

        $arr_additional = array();
        $additional = json_decode($this->additionals);
        foreach (PostAdditional::where('itm_code', $this->itm_code)->get() as $key => $addi) {
            foreach ((array) $additional as $key => $additi) {
                if ($addi->id == $additi) {
                    $arr_additional[] = $addi;
                }
            }
        }

        return [
            'id' => $this->id,
            'emp_id' => $this->emp_id,
            'itm_code' => $this->itm_code,
            'title_en' => $this->title_en,
            'photo' => $pro->photo,
            'expiry_date' => $this->expiry_date,
            'qty' => $this->qty,
            'unit_id' => $this->unit_id,
            'unit_title' => $this->unit_title,
            'is_tax' => $this->is_tax,
            'price_selling' => $this->price_selling,
            'discount' => $this->discount,
            'discount_title' => $this->discount_title,
            'discount_price' => $this->discount_price,
            'is_discount'  => $this->is_discount,
            'attributes' => $attributes,
            'additionals' => $arr_additional,
        ];
    }
}
