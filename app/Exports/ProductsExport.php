<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {

        $product = Post::select('itm_code', 'title')
        ->where('itm_code', '>' ,99999)
        ->whereNotIn('cat_id', [2,3])
        ->get();
        
        return view('admin.post.export', [
            'products' => $product
        ]);
    }
}
