<?php

namespace App\Imports;

use App\Models\Post;
use App\Models\Stock;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ProductsImport implements ToCollection,
SkipsOnError,
SkipsOnFailure,
WithChunkReading,
ShouldQueue,
WithEvents
{

    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) 
        {

            if ($i != 0) {
                $product = Post::where('itm_code', $row[0])->get();
                if ($product->count() > 0) {
                    Post::where('itm_code', $row[0])->update([
                        'title' => $row[1],
                        'title_en' => $row[2],
                        'cat_id' => $row[9],
                        'is_show' => 1,
                        'itm_code' => $row[0],
                        'itm_unit1' => $row[4],
                        'itm_unit2' => $row[5],
                        'itm_unit3' => $row[6],
                        'mid' => $row[7],
                        'sm' => $row[8],
                        'is_tax' => $row[3],
                        'status' => 1
                    ]);

                    if ($row[15] != null) {
                        $qty = $row[15];
                    } else {
                        $qty = 0;
                    }
    
                    Stock::where('itm_code', $row[0])->where('branch_id', 1)->update([
                        'qty' => $qty,
                        'price_purchasing' => $row[10],
                        'price_selling' => $row[11],
                        'price_minimum_sale' => $row[12],
                        'production_date' => $row[13],
                        'expiry_date' => $row[14],
                        'itm_code' => $row[0]
                    ]);
                } else {
    
                    $data = new Post;
                    $data->title = $row[1];
                    $data->title_en = $row[2];
                    $data->cat_id = $row[9];
                    $data->is_show = 1;
                    $data->itm_code = $row[0];
                    $data->itm_unit1 = $row[4];
                    $data->itm_unit2 = $row[5];
                    $data->itm_unit3 = $row[6];
                    $data->mid = $row[7];
                    $data->sm = $row[8];
                    $data->status = 1;
                    $data->is_tax = $row[3];
                    try {
                        $data->save();
            
                        if ($row[15] != null) {
                            $qty = $row[15];
                        } else {
                            $qty = 0;
                        }
                        
                        $stock = new Stock;
                        $stock->qty = $qty;
                        $stock->price_purchasing = $row[10];
                        $stock->price_selling = $row[11];
                        $stock->price_minimum_sale = $row[12];
                        $stock->production_date = $row[13];
                        $stock->expiry_date = $row[14];
                        $stock->itm_code = $row[0];
                        $stock->branch_id = 1;
                        $stock->save();
            
                    } catch (\Exception $e) {
                        // return response()->json(['msg' => 'Failed']);
                    }
                }
            }
            

        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
    }

    public function onFailure(Failure ...$failure)
    {
    }
}
