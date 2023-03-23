<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="">
            <!--<a href="index" class="logo text-center">Admiria</a>-->
            <a href="index" class="logo"><img src="{{asset('public/uploads/posts')}}/{{$Settings->logo1}}" height="50"
                                              alt="{{$Settings->title}}"></a>
        </div>
    </div>
    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>

                <li>
                    <a href="{{url('/admin')}}" class="waves-effect"><span> لوحة القيادة</span> <i
                            class="fa fa-home"></i></a>
                </li>

                <li class="menu-title">ادارة المبيعات</li>
                <li>
                    <a href="{{url('admin/cashier')}}" class="waves-effect"><span> فاتورة جديده</span> <i
                            class="fa fa-paperclip"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/orders')}}" class="waves-effect"><span> قائمة الفواتير</span> <i
                            class="fa fa-paperclip"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/sales-inv-report')}}" class="waves-effect"><span> ملخص المبيعات</span> <i
                            class="fa fa-paperclip"></i></a>
                </li>
                <li class="menu-title">ادارة المخزون</li>
                <li>
                    <a href="{{url('admin/stocks')}}" class="waves-effect"><span> المخزون</span> <i
                            class="fa fa-pagelines"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/transfer')}}" class="waves-effect"><span> اذونات التحويل</span> <i class="fa fa-pagelines"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/inventory')}}" class="waves-effect"><span> جرد المخزون</span> <i class="fa fa-pagelines"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/damageditem')}}" class="waves-effect"><span> الاصناف التالفة</span> <i
                            class="fa fa-empire"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/deficiencies')}}" class="waves-effect"><span> النواقص</span> <i
                            class="fa fa-empire"></i></a>
                </li>
                <li class="menu-title">ادارة المشتريات</li>
                <li>
                    <a href="{{url('admin/create_purchas')}}" class="waves-effect"><span> فاتورة شراء</span> <i
                            class="fa fa-pagelines"></i></a>
                </li>
                <li>
                    <a href="{{url('admin/purchass')}}" class="waves-effect"><span> قائمة الفواتير</span> <i
                            class="fa fa-compass"></i></a>
                </li>


                @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                    <li class="menu-title">التقارير</li>
                    <li>
                        <a href="{{url('admin/tax-report')}}" class="waves-effect"><span> التقرير الضريبي</span> <i
                                class="fa fa-paperclip"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/sales-report')}}" class="waves-effect"><span> تقرير المبيعات</span> <i
                                class="fa fa-money"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/bonus-report')}}" class="waves-effect"><span> تقرير الموظفين</span> <i
                                class="fa fa-money"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/voucher')}}" class="waves-effect"><span>السندات</span> <i
                                class="fa fa-paperclip"></i></a>
                    </li>

                    <li class="menu-title">ادارة المحتوى</li>
                    <li>
                        <a href="{{url('admin/branch')}}" class="waves-effect"><span> الفروع</span> <i
                                class="fa fa-server"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/category')}}" class="waves-effect"><span> الاقسام</span> <i
                                class="fa fa-server"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/unit')}}" class="waves-effect"><span> الوحدات</span> <i
                                class="fa fa-empire"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/products')}}" class="waves-effect"><span> المنتجات</span> <i
                                class="fa fa-empire"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/attribute')}}" class="waves-effect"><span> الخصائص</span> <i
                                class="fa fa-empire"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/clients')}}" class="waves-effect"><span> العملاء </span> <i
                                class="fa fa-users"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/tablecat')}}" class="waves-effect"><span> اقسام الطاولات </span> <i
                                class="fa fa-users"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/table')}}" class="waves-effect"><span>  الطاولات </span> <i
                                class="fa fa-users"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/printer')}}" class="waves-effect"><span> اعدادات الطابعات </span> <i
                                class="fa fa-users"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/supplier')}}" class="waves-effect"><span> الموردين </span> <i
                                class="fa fa-users"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/sliders')}}" class="waves-effect"><span> السلايدر</span> <i
                                class="fa fa-sliders"></i></a>
                    </li>
                    <li>
                        <a href="{{url('admin/discount')}}" class="waves-effect"><span> نوع الخصم</span> <i
                                class="fa fa-sliders"></i></a>
                    </li>
                    <li class="menu-title">الاعدادات</li>
                    <li>
                        <a href="{{url('admin/edit_setting/1')}}" class="waves-effect"><span> الاعدادات</span> <i
                                class="fa fa-edit"></i></a>
                    </li>

                    <li>
                        <a href="{{url('admin/roles')}}" class="waves-effect"><span> الصلاحيات</span> <i
                                class="fa fa-edit"></i></a>
                    </li>

                    <li>
                        <a href="{{url('admin/admins')}}" class="waves-effect"><span> المديرين / العاملين</span> <i
                                class="fa fa-user-secret"></i></a>
                    </li>
                @endif

                {{--                <li>--}}
                {{--                    <a href="{{url('admin/deligate')}}" class="waves-effect"><span> المناديب</span> <i class="fa fa-motorcycle"></i></a>--}}
                {{--                </li>--}}
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->

