@extends('admin.layouts.master') 

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<h3 class="page-title">المديرين</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
						<div class="col-sm-6">
                        
                            <div class="p-2">
                                <h3 class="panel-title font-20">
                                    @if ($data->photo != NULL)
                                        <a class="image-popup-vertical-fit" href="{{ URL::asset('public/uploads/') }}/{{$data->photo}}" title="Caption. Can be aligned it to any side and contain any HTML.">
                                            <img class="img-responsive" src="{{ URL::asset('public/uploads/') }}/{{$data->photo}}"  width="145">
                                        </a> 
                                    @endif
                                </h3>
                                <h3 class="panel-title font-20"><strong>تفاصيل الحساب</strong></h3>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <tr>
                                        <td class="text-left"><strong>الاسم بالكامل :</strong></td>
                                        <td class="text-center"><?php echo $data->name ; ?></td>
                                   </tr>
                                    <tr>
                                        <td class="text-left"><strong>رقم الجوال :</strong></td>
                                        <td class="text-center"><?php echo $data->phone ; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"><strong>البريد الالكتروني :</strong></td>
                                        <td class="text-center"><?php echo $data->email ; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-left"><strong> تاريخ الانشاء :</strong></td>
                                        <td class="text-center"><?php echo $data->created_at ; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"><strong>حالة الحساب :</strong></td>
                                        <td class="text-center"><?php if ($data->is_active == 1) {
                                            echo 'نشط';
                                        } else {
                                            echo 'غير نشط' ;
                                        } ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <div class="p-2">
                                                <a href="{{ url('/admin/edit_admin/'.$data->id) }}" class="btn btn-outline-purple waves-effect waves-light">تعديل الحساب</a>
                                            </div></td>
                                        <td class="text-center"></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>	

                        <div class="col-sm-6">                            
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection

@section('script-bottom')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
        $('#datatable2').DataTable();
    } );

    $("#btn_delete").click(function(event){
        event.preventDefault();
        var checkIDs = $("#datatable input:checkbox:checked").map(function(){
        return $(this).val();
        }).get(); // <----

        if (checkIDs.length > 0) {
            var token = $(this).data("token");
            $.ajax(
            {
                url: "{{route('admin.delete_admin')}}",
                type: 'post',
                dataType: "JSON",
                data: {
                    "id": checkIDs,
                    "_method": 'post',
                    "_token": token,
                },
                success: function (data) {
                    if(data.msg == "Success") {
                        console.log(data.msg)
                        location.reload();
                    } else {
                        console.log(data.msg)
                    }
                },
                fail: function(xhrerrorThrown){
                    
                }
            });
        }

    });
</script>
@endsection
