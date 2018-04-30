<!DOCTYPE html>
<html class="smart-style-1" lang="es-ES">
<head>
    <meta charset="utf-8">
    <title> AcmEv </title>
    <meta name="description" content="AcmEv">
    <meta name="author" content="Group 16 - D&P Universidad de Sevilla">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Notifications -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/iziToast.min.css')}}">

    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/custom.css')}}">
    <!-- FontAwesome css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/fontawesome-all.min.css')}}">
    <!-- SmartWizard css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/smartWizard/smart_wizard.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/smartWizard/smart_wizard_theme_arrows.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/smartWizard/smart_wizard_theme_circles.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/smartWizard/smart_wizard_theme_dots.css')}}">
    <!-- Bootstrap Select css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/bootstrap-select.min.css')}}">



    <!-- #FAVICONS -->
    {{--<link rel="shortcut icon" href="{{asset('')}}" type="image/x-icon">--}}
    {{--<link rel="icon" href="{{asset('')}}" type="image/x-icon">--}}

    <!-- Otras hojas de estilo y hojas de estilos personalizadas -->

    @yield('styles')
</head>
<body>
<!-- Page Content -->


<div id="main-wrapper" class="wrapper">
    @include('layouts.default-menu')
    <div id="content" class="p-4">
        <!-- Header -->
            {{--@include('layouts.default-header')--}}
        <!-- END HEADER -->
        @yield('content')
    </div>
</div>
<!-- #PAGE FOOTER -->
@include('layouts.default-footer')
<!-- END FOOTER -->
@if(!Auth::check())
    @include('auth.login')
@endif
<!-- End of Page Content -->


<!-- jQuery -->
    <script src="{{asset('js/jQuery.js')}}"></script>
<!-- Bootstrap -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- CUSTOM NOTIFICATION -->
<script src="{{asset('js/iziToast.min.js')}}"></script>
<!-- Smart Wizard -->
<script src="{{asset('js/smartWizard.js')}}"></script>
<!-- Bootstrap Select -->
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>

<!-- CUSTOM Scripts -->
<script src="{{asset('js/custom.js')}}"></script>

<!--AJAX CONFIG-->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>

@yield('scripts')
</body>

</html>