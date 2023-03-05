<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>فاتورة ضريبية مبسطة</title>
        <style>
            body {
                    font: 13pt Georgia, "Times New Roman", Times, serif;
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
                    text-align: right;
                }
                .timedate {
                    font: 10pt;
                }
                .qrcode {text-align: center;}
            @media print {
                body {
                    font: 9pt Georgia, "Times New Roman", Times, serif;
                    line-height: 1.3;
                    background: #fff !important;
                    color: #000;
                    text-align: inherit;
                }
                .ticket {border: none;
                    width: 100%;
                    display: auto;}
                .table {
                    width: 100%;
                    font: 6pt Georgia, "Times New Roman", Times, serif;
                }
                .timedate {
                    font: 6pt;
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
                <img src="{{asset('public/uploads/posts')}}/{{$setting->logo2}}" width="150" alt="Logo">
            </div>
            <p class="right"><strong>{{$setting->title}}</strong>
                <br>
                @if ($data[0]->order_type == 0)
                رقم الفاتورة : {{$data[0]->order_id}} <br>
                @else
                فاتوره مرتجع رقم : {{$data[0]->order_id}} عن فاتورة رقم {{$data[0]->order_return}} <br>
                @endif
                تاريخ الفاتورة: <small class="timedate">{!! date('y-m-d | h:i a', strtotime($data[0]->created_at)) !!} </small><br>
                الرقم الضريبي: {{$setting->tax_num}}<br>
                الفرع: {{json_decode($data[0]->branch)->name}}<br>
                بواسطة: {{$data[0]->add_by_name}}<br>
                اسم العميل: {{json_decode($data[0]->client)->name}}<br></p>

            <hr>
            <table class="table">
                <thead>
                <tr>

                    <td class="text-center"><strong>اسم المنتج</strong></td>
                    <td class="text-center"><strong>الكمية</strong></td>
                    <th class="text-center"><strong>السعر</strong></th>
                </tr>
                </thead>
                <tbody>
                @php 
                    $total_product = 0;
                @endphp
                @foreach ($data as $key => $pro)
                    <tr>
                        <td class="text-center">
                            {{json_decode($pro->product)->title_en}}<br>
                            - {{$pro->unit_title}}<br>
                            @if ($pro->expiry_date)
                            {!! date('y-m-d', strtotime($pro->expiry_date)) !!}
                            @endif
                        </td>
                        <td class="text-center">
                            الكمية: {{$pro->qty}}<br>
                            السعر: {{$pro->price_selling}}
                            @if ($pro->is_discount == 0)
                                <br>
                                @if ($pro->is_tax == 1)
                                الضريبة: {{round(($pro->price_selling * $pro->qty) * ($pro->tax_setting / 100), 2)}}
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($pro->is_tax == 1)
                            @if ($pro->is_discount == 0)
                            @php $tax = round(($pro->price_selling * $pro->qty) * ($pro->tax_setting / 100), 2); @endphp
                            @else
                            @php $tax = 0; @endphp
                            @endif
                            @else
                            @php $tax = 0; @endphp
                            @endif
                            {{round($tax + ($pro->price_selling * $pro->qty), 2)}}
                        </td>
                    </tr>
                    @php 
                        $total_product = round($total_product + ($pro->price_selling * $pro->qty), 2);
                    @endphp
                @endforeach
                <tr>
                    <td colspan="3"><hr> </td>
                </tr>
                @if ($pro->is_discount > 0)
                    <tr>
                        <td colspan="2">اجمالي المنتجات: </td>
                        <td>{{$total_product}} {{$Settings->currency}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">خصم الفاتورة: <br> <small>{{$pro->discount_title}}<small></td>
                        <td>{{$total_discount = $total_product - $pro->total_sub }} {{$Settings->currency}}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2">الاجمالى قبل الضريبة: </td>
                    <td>{{$pro->total_sub}} {{$Settings->currency}}</td>
                </tr>
                <tr>
                    <td colspan="2">اجمالى الضريبة:  </td>
                    <td>{{$pro->total_tax }} {{$Settings->currency}}</td>
                </tr>
                <tr>
                    <td colspan="2">الاجمالى بعد  الضريبة:  </td>
                    <td>{{$pro->total_sub  + $pro->total_tax }} {{$Settings->currency}}</td>
                </tr>
                <tr>
                    <td colspan="3"><hr> </td>
                </tr>
                </tbody>
            </table>

            <p class="qrcode">{{$qrcode}}</p>
            <p class="centered"><?php echo $setting->address .' - ' . $setting->phone1 .' - ' . $setting->phone2 ; ?></p>
        </div>

        <hr>

        <script type="text/javascript">
            window.print();
            setTimeout("closePrintView()", 1000);

            function closePrintView() {
                document.location.href = "{{url('admin/cashier/')}}";
            }
        </script>
    </body>
</html>
