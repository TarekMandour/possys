

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{ $Settings->title }}</title>
        @include('admin.layouts.head')
    </head>
    <body class="fixed-left">
        <!-- Loader -->
{{--        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>--}}
        @yield('content')
        @include('admin.layouts.footer-script')
    </body>
</html>
