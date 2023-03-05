<!-- Top Bar Start -->
@if(\Illuminate\Support\Facades\Auth::user()->type != 0)
    <div class="topbar" style="right: 0px;">

        <nav class="navbar-custom">

            <ul class="list-inline float-right mb-0">

                <li class="list-inline-item dropdown notification-list hidden-xs-down">
                    <a href="{{url('admin/kitchen')}}" class="btn btn-outline-purple waves-effect waves-light">شاشة
                        المطبخ</a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->type != 2)
                    <li class="list-inline-item dropdown notification-list hidden-xs-down">
                        <a href="{{url('admin/orders')}}"
                           class="btn btn-outline-purple waves-effect waves-light">الطلبات</a>
                    </li>

                    <li class="list-inline-item dropdown notification-list hidden-xs-down">
                        <a href="{{url('admin/cashier_today')}}"
                           class="btn btn-outline-purple waves-effect waves-light">طلبات اليوم</a>
                    </li>


                    <li class="list-inline-item dropdown notification-list hidden-xs-down">
                        <a href="{{url('admin/cashier')}}" class="btn btn-outline-purple waves-effect waves-light">طلبية
                            جديده</a>
                    </li>

                    <li class="list-inline-item dropdown notification-list hidden-xs-down">
                        <a href="{{url('admin/deligate')}}"
                           class="btn btn-outline-purple waves-effect waves-light">المناديب </a>
                    </li>
            @endif
            <!-- Fullscreen -->
                <li class="list-inline-item dropdown notification-list hidden-xs-down">
                    <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                        <i class="mdi mdi-fullscreen noti-icon"></i>
                    </a>
                </li>

                <li class="list-inline-item dropdown notification-list hidden-xs-down">
                    <a class="nav-link waves-effect" href="{{url('/admin')}}" id="btn-fullscreen">
                        <i class="dripicons-home noti-icon"></i>
                    </a>
                </li>

                <!-- User-->
                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                       href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        @if (Auth::user()->photo == NULL || empty(Auth::user()->photo))
                            <img src="{{ URL::asset('public/adminAssets/ar/images/users/avatar-1.jpg') }}"
                                 alt="user" class="rounded-circle">
                        @else
                            <img src="{{ URL::asset('public/uploads') }}/{{Auth::user()->photo}}" alt="user"
                                 class="rounded-circle">
                        @endif
                        <span>{{Auth::user()->name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            تسجيل الخروج
                            <i class="dripicons-exit text-muted"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>

            <div class="clearfix"></div>
        </nav>
    </div>
    <!-- Top Bar End -->
@endif
