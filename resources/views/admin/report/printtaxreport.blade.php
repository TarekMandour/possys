@extends('admin.layouts.master-without-nav')

@section('content')
    @if ($data)
        <table id="" class="table table-striped table-bordered dt-responsive" cellspacing="0">
            <thead>
            <tr>
                <th>تم الانشاء</th>
                <th>الاجمالي بعد الضرية</th>
                <th>الضريبة</th>
                <th>رقم الفاتورة</th>

            </tr>
            </thead>
            <tbody>
            @php
                $total_tax = 0;
                $total_sub = 0;
            @endphp
            @foreach ($data as $item=> $row)
                <tr>
                    <td>{{Carbon\Carbon::parse($row[0]->sdate)}}</td>
                    <td>{{$row[0]->total_sub + $row[0]->total_tax}}</td>
                    <td>{{$row[0]->total_tax}}</td>
                    <td>
                        {{$row[0]->order_id}}
                    </td>
                    @php
                        $total_tax += $row[0]->total_tax;
                        $total_sub += $row[0]->total_sub;
                    @endphp
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="cart-box col-6">
                <div class="cart-details">
                    <div class="cart-details-title">
                        اجمالى الضريبة
                    </div>
                    <div class="cart-details">
                        {{$total_tax}}
                        {{$Settings->currency}}
                    </div>
                </div>
            </div>
            <div class="cart-box col-6">
                <div class="cart-details">
                    <div class="cart-details-title">
                        الاجمالى بعد الضريبة
                    </div>
                    <div class="cart-details">
                        {{$total_tax + $total_sub  }}
                        {{$Settings->currency}}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>

            window.print();

    </script>
@endsection


