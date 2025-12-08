<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="A complete solution for a digital palika." name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="Nexora Info Pvt Ltd" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('images/np.png') }}" />
{{--    <!-- plugins -->--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/plugins/select2.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/plugins/sweetalert2.min.css') }}" type="text/css" />
    <link href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css" rel="stylesheet" type="text/css"/>
    {{--    <!-- app styles -->--}}
    <link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"
          media='screen,print' />
    <link href="{{ asset('assets/backend/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
{{--    <!-- icons -->--}}
    <link href="{{ asset('assets/backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/scss/style.css') }}" type="text/css" />

    @livewireStyles
    @stack('style')
</head>

<body>
<div id="preloader">
    <img class="heartBeat animate" src="{{ asset('assets/backend/images/logo.png') }}" alt="">
</div>
<div id="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.side_nav')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid text-center">
                {{ date('Y') }} &copy; {{config('app.name')}} </a>
            </div>
        </footer>
    </div>
</div>
<div class="rightbar-overlay"></div>
<script src="{{ asset('assets/backend/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/plugins/sweetalert2.min.js') }}"></script>

@include('sweetalert::alert')

@stack('scripts')
@livewireScripts

<script src="{{ asset('assets/backend/js/app.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/custom.js') }}"></script>
<script src="{{ asset('assets/backend/print/print.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
</body>

</html>
