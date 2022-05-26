<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $judul }}</title>
    <meta name="description" content="ShaynaAdmin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('components.dashboard.style')

</head>

<body>
    <!-- Sidebar Panel -->
    @include('components.dashboard.sidebar')
    <!-- /#Sidebar-panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">

        {{-- SweetAlert --}}
        @include('sweetalert::alert')

        <!-- Navbar Header-->
        @include('components.dashboard.navbar')
        <!-- /#Navbar Header -->

        <!-- Content -->
        @yield('content')
        <!-- /.content -->

        <div class="clearfix"></div>
    </div>
    <!-- /#right-panel -->

    @include('components.dashboard.script')
</body>
</html>
