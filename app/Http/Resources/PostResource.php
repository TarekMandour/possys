<?php

namespace App\Http\Resources;
use App\Models\Attribute;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $arr_attri = array();
        foreach (Attribute::get() as $key => $att) {
            $arr_attribute = array();
            foreach ($this->attribute as $key => $proatt) {
                if ($att->id == $proatt->attribute_id) {
                    $arr_attribute[$proatt->attribute_name][] = $proatt;
                }
            }
            if (count($arr_attribute) > 0) {
                $arr_attri[] = $arr_attribute;
            }
        }
        dd($this->Unit1);
        return [
            'id' => $this->id,
            'itm_code' => $this->itm_code,
            'title' => $this->title,
            'content' => $this->content,
            'photo' => $this->photo,
            'cat_id' => $this->cat_id,
            'is_show' => $this->is_show,
            'is_tax' => $this->is_tax,
            'itm_unit1' => $this->itm_unit1,
            'itm_unit2' => $this->itm_unit2,
            'itm_unit3' => $this->itm_unit3,
            'mid' => $this->mid,
            'sm' => $this->sm,
            'status' => $this->status,
            'created_at'  => $this->created_at,
            'stock' => $this->stock,
            'additional' => $this->addi,
            'attribute' => $arr_attri,
        ];
    }
}
