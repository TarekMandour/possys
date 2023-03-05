<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>طباعة الباركود</title>
        <style>
            body {
                    font: 9pt Georgia, "Times New Roman", Times, serif;
                    line-height: 1.3;
                    background: #fff !important;
                    color: #000;
                    text-align: center;
                }
                .ticket {
                    border: 1px dotted #000;
                    width: 8cm;
                    display: inline-block;
                }
                .table {
                    width: 100%;
                    font: 9pt Georgia, "Times New Roman", Times, serif;
                }
                .right,.table {
                    text-align: center;
                }
                .timedate {
                    font: 10pt;
                }
                .qrcode {text-align: center;}
            @media print {
                body {
                    font: 4pt Georgia, "Times New Roman", Times, serif;
                    line-height: 1;
                    background: #fff !important;
                    color: #000;
                    text-align: inherit;
                }
                .ticket {border: none;
                    width: 100%;
                    display: auto;}
                .table {
                    width: 100%;
                    font: 2.5pt Georgia, "Times New Roman", Times, serif;
                }
                .timedate {
                    font: 4pt;
                }
            }

            @page {
                size: auto;   /* auto is the initial value */
                margin: .2cm;  /* this affects the margin in the printer settings */
                font-family: emoji !important;
            }
        </style>
    </head>
    <body>
        <div class="ticket">
            <div style="width:100%;text-align:center;">
                <table class="table" style="display: inline;">
                    <thead>
                        <tr>
                            <td class="text-left"></td>
                            <td class="text-left"><strong style="font-family: tahoma;text-align:center;">{{ $Settings->title }}</strong></td>
                            <th class="text-left"></th>
                        </tr>
                        <tr>
                            <td class="text-left"></td>
                            <td class="text-left"><strong style="font-family: tahoma;text-align:center;">@if($data->Product){{$data->Product->title_en}}@endif</strong></td>
                            <th class="text-left"></th>
                        </tr>
                        <tr>
                            <td class="text-left"></td>
                            <td class="text-left">
                                <?php
                                if (strlen($data->itm_code) == 4) {
                                    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data->itm_code, 'C128') . '" alt="barcode" width="60%"/>';
                                } else {
                                    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data->itm_code, 'C128') . '" alt="barcode" width="90%"/>';
                                }
                                    
                                ?>
                                
                            </td>
                            <th class="text-left"></th>
                        </tr>
                        <tr>
                            <td class="text-left" style="width:25%;text-align:right;"></td>
                            
                            <td class="text-left">
                                @php 
                                $product = \App\Models\Post::where('itm_code', $data->itm_code)->first();
                                @endphp
                                @if($product->is_tax == 0)
                                <strong style="font-family: tahoma;margin-right:2px;float: right;">{{$data->price_selling}} <strong style="float: right;"> SR</strong></strong> 
                                @else
                                <strong style="font-family: tahoma;margin-right:2px;float: right;">{{round(($data->price_selling * ($Settings->tax / 100)) + $data->price_selling, 2).' '}} <strong style="float: right;"> SR</strong></strong>
                                @endif
                                <strong style="font-family: tahoma;text-align:center;">{{' | '.$data->itm_code.' | '}}</strong>
                                <strong style="font-family: tahoma;margin-left:2px;float: left;">{{\Carbon\Carbon::parse($data->expiry_date)->format("Y-m")}}</strong>
                            </td>
                            
                            <td class="text-left" style="width:25%;text-align:right;"></td>
                        </tr>


                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <script type="text/javascript">
            window.print();
            window.onafterprint = function (e) {
                window.close();
            };
        </script>
    </body>
</html>