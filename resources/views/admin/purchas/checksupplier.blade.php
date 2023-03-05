<div class="col-sm-12 col-md-12 col-lg-12 pb-30" dir="rtl">
    <div class="product-details-item">
        <div class="product-details-caption">

            @if ($client)
            <address>
                <strong>اسم المورد: {{$client->title}}</strong><br>
                رقم الجوال: {{$client->phone}}<br>
                مسؤول المبيعات: {{$client->sales_name}}<br>
                رقم الجوال: {{$client->phone2}}<br>
                العنوان: {{$client->address}}<br>
                رقم الحساب: {{$client->num}}<br>
                الرقم الضريبي: {{$client->tax_number}}
            </address>
            @else
            <address>
                <strong>لا يوجد مورد لهذا الرقم</strong>
            </address>
            @endif
        </div>
    </div>
</div>

