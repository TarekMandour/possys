<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostMonthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if ($this) {
            foreach ($this as $days) {
                foreach ($days as $key => $d) {
                    foreach ($d as $dat) {
                        $more[$key][] = array('id' => $dat->id,
                        'title' => $dat->append_title,
                        'content' => $dat->append_content,
                        'main_photo' => $dat->photo,
                        'cat_id' => $dat->cat_id,
                        'created_at' => $dat->created_at,
                        'postgallery' => $dat->postgallery
                        ) ;
                    }
                }
            }
        }

        // if ($this) {
        //     foreach ($this as $key => $days) {
        //         foreach ($days as  $key => $d) {
        //         $more['dagggggys'][] = $key;
        //         }
        //     }
        // }

        return $more;
    }
}
