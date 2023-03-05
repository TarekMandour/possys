<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="images/favicon.png" rel="icon" />
<title>الفاتورة</title>
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts
======================= -->
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<!-- Stylesheet
======================= -->
<link rel="stylesheet" type="text/css" href="https://harnishdesign.net/demo/html/koice/vendor/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://harnishdesign.net/demo/html/koice/vendor/font-awesome/css/all.min.css"/>
<link rel="stylesheet" type="text/css" href="https://harnishdesign.net/demo/html/koice/css/stylesheet.css"/>
<style>
    body {
        font-family: 'Tajawal' !important;
    }
    .card-footer , .card-header{
        padding: 0.5rem 1rem;
        background: none; 
        border-top: 1px solidrgba(0,0,0,.125);
    }
    .card {
        border: none;
    }
</style>
</head>
    <body>
        <div class="container-fluid invoice-container"> 
            <!-- Header -->
            <header>
              <div class="row align-items-right">
                  <div class="col-sm-5 text-right"></div>
                  <div class="col-sm-7 text-right text-sm-start mb-3 mb-sm-0">  
                    <h4 class="mb-0" style="text-align: right;">{{$setting->title}}</h4>
                  </div>
                
              </div>
              <hr>
            </header>
            
            <!-- Main Content -->
            <main>
          
              <div class="row">
                <div class="col-4" style="text-align: right;"> 
                  <strong>بيانات المورد</strong>
                  <address>
                    {{json_decode($data[0]->supplier)->title}}<br />
                    {{json_decode($data[0]->supplier)->phone}}<br />
                    @if (!empty(json_decode($data[0]->supplier)->city))
                    {{json_decode($data[0]->supplier)->city}}<br />
                    @endif
                    @if (!empty(json_decode($data[0]->supplier)->address))
                    {{json_decode($data[0]->supplier)->address}}<br />
                    @endif
                    <strong>رقم السجل الضريبي</strong><br />
                    {{json_decode($data[0]->supplier)->tax_number}}<br />
                  </address>
                </div>
                <div class="col-4" style="text-align: right;"> 
                  <strong>رقم الفاتورة</strong>
                  <address>
                    {{$data[0]->order_id}}  <br />
                  </address>
                  <strong>التاريخ</strong>
                  <address>
                    {!! date('y-m-d | h:i a', strtotime($data[0]->created_at)) !!}<br />
                  </address>
                </div>
                <div class="col-4" style="text-align: right;"> 
                  <strong>{{$setting->title}}</strong>
                  <address>
                    {{$setting->phone1}}<br />
                    {{$setting->address}}<br />
                  <strong>رقم السجل الضريبي</strong><br />
                  {{$setting->tax_num}}<br />
                  </address>
                </div>
          
              </div>
              <div class="card">
                
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table mb-0" dir="rtl">
                      <thead class="card-header">
                      <tr>
                        <td class="col-3"><strong>اسم المنتج</strong></td>
                        <td class="col-2 text-end"><strong>الكمية</strong></td>
                        <td class="col-3 text-end"><strong>الضريبة</strong></td>
                        <td class="col-2 text-end"><strong>السعر</strong></td>
                        <td class="col-2 text-end"><strong>المجموع</strong></td>
                      </tr>
                    </thead>
                      <tbody>
                            @php 
                                $total_purcase = 0; $total_ptatcase = 0;
                            @endphp
                          @foreach ($data as $key => $pro)
                          <?php $total_purcase += ($pro->qty * $pro->price_purchasing); ?>
                            <tr>
                                <td class="col-3">{{json_decode($pro->product)->title}}<br>
                                    {{$pro->unit_title}}</td>
                                <td class="col-2 text-end">{{$pro->qty}}</td>
                                <td class="col-2 text-end">
                                    @if ($pro->is_tax == 1)
                                    @php $tax = round(($pro->price_purchasing * $pro->qty) * ($Settings->tax / 100),2) @endphp
                                    @else
                                    @php $tax = 0; @endphp
                                    @endif
                                    {{$tax}}
                                    <?php $total_ptatcase += $tax; ?>
                                </td>
                                <td class="col-2 text-end">
                                  {{$pro->price_purchasing}}
                                </td>
                                <td class="col-2 text-end">{{ round($tax + ($pro->price_purchasing * $pro->qty),2)}}</td>
                            </tr>
                        @endforeach
                        
                      </tbody>
                      <tfoot class="card-footer">
                        <tr>
                            <td class="text-center border-bottom-0" colspan="2"></td>
                          <td class="text-end" colspan="2"><strong>الاجمالى قبل الضريبة:</strong></td>
                          <td class="text-end">{{$total_purcase}}</td>
                        </tr>
                        <tr>
                            <td class="text-center border-bottom-0" colspan="2"></td>
                            <td class="text-end" colspan="2"><strong>اجمالى الضريبة:</strong></td>
                            <td class="text-end">{{$total_ptatcase}}</td>
                          </tr>
                        <tr>
                            <td class="text-center border-bottom-0" colspan="2"></td>
                          <td class="text-end border-bottom-0" colspan="2"><strong>الاجمالى بعد  الضريبة:</strong></td>
                          <td class="text-end border-bottom-0">{{$total_purcase + $total_ptatcase}}</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </main>
        </div>


        <script type="text/javascript">
            window.print();
            setTimeout("closePrintView()", 1000);

            function closePrintView() {
                document.location.href = "{{url('admin/create_purchas/')}}";
            }
        </script>
    </body>
</html>
