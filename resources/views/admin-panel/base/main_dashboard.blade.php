<html lang="en" dir="">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<head>
    @include('admin-panel.base.head')
    @yield('css')
</head>

<body class="text-left">
<div class="app-admin-wrap layout-sidebar-large">
{{--    @include('admin-panel.base.header')--}}





{{--    <div class="main-content-wrap sidenav-open d-flex flex-column">--}}
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            @yield('content')
        </div>
{{--    </div>--}}
</div>

@include('admin-panel.base.need_js')
@yield('js')
</body>

</html>
