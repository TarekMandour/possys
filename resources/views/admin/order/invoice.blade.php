<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>فاتورة ضريبية مبسطة</title>
        <style>
            body {
                    font: 13pt Georgia, "Times New Roman", Times, serif;
                    line-height: 1.3;
                    background: #fff !important;
                    color: #000;
                    text-align: center;
                }
                .ticket { border: 1px dotted #000;
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
                رقم الفاتورة: {{$data[0]->order_id}}<br>
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
                @foreach ($data as $key => $pro)
                    <tr>
                        <td class="text-center">
                            {{json_decode($data[0]->product)->title_en}}<br>
                            - {{$pro->unit_title}}<br>
                            - {{$pro->expiry_date}}
                        </td>
                        <td class="text-center">
                            الكمية: {{$pro->qty}}<br>
                            السعر: {{$pro->price_selling}}<br>
                            الضريبة: {{round(($pro->price_selling * $pro->qty) * ($Settings->tax / 100), 2)}}
                        </td>
                        <td class="text-center">
                            @php $tax = round(($pro->price_selling * $pro->qty) * ($Settings->tax / 100), 2); @endphp
                            {{round($tax + ($pro->price_selling * $pro->qty), 2)}}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><hr> </td>
                </tr>
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
                    <td>{{$pro->total_sub + $pro->total_tax }} {{$Settings->currency}}</td>
                </tr>
                <tr>
                    <td colspan="3"><hr> </td>
                </tr>
                </tbody>
            </table>
            
            <p class="qrcode">{{ $qrcode }}</p>
            <p class="centered"><?php echo $setting->address .' - ' . $setting->phone1 .' - ' . $setting->phone2 ; ?></p>
        </div>

        <hr>

    </body>
</html>
