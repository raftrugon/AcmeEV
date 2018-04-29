<!DOCTYPE html>
<html class="smart-style-1" lang="es-ES">
<head>
    <meta charset="utf-8">
    <title> AcmEv </title>
    <meta name="description" content="AcmEv">
    <meta name="author" content="Group 16 - D&P Universidad de Sevilla">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('css/font-awesome.min.css')}}">

    <!-- Notifications -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('css/iziToast.min.css')}}">

    <!-- Select Picker -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('js/plugin/bootstrap-select/bootstrap-select.min.css')}}">

    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('css/custom-client.css')}}">

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{asset('')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('')}}" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Loading Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>

    <!-- Loading Third Party Styles -->
    <link rel="stylesheet" href="{{asset('third-party/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/et-line/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/elegant-icons/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/pe-icon-7-stroke/css/pe-icon-7-stroke.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/pe-icon-7-stroke/css/helper.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/nivo-lightbox/css/nivo-lightbox.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/nivo-lightbox/themes/default/default.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/animate/css/animate.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/owl/css/owl.carousel.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/owl/css/owl.theme.css')}}"/>
    <link rel="stylesheet" href="{{asset('third-party/form-validation/css/formValidation.min.css')}}"/>
    <!-- Loading Theme's Styles -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Otras hojas de estilo y hojas de estilos personalizadas -->

    @yield('styles')
</head>
<body class="header-left-side in">
<div class="loader" style="display: none;">
    <div class="spinner"></div>
</div>
<!-- Page Content -->

<div class="page-content uncover-footer-body">
    <!-- Header -->
@include('layouts.default-header')

<!-- END HEADER -->
    <div class="uncover-footer-content">
        <div style="background-color: white!important;min-height:85vh">
            @yield('content')
        </div>
        <!-- #PAGE FOOTER -->
    @include('layouts.default-footer')
    <!-- END FOOTER -->
    </div>

</div><!-- End of Page Content + Uncover Footer Body -->


<!-- #PLUGINS -->
    <script src="{{URL::to('third-party/easing/js/jquery.easings.min.js')}}"></script>
    <script src="{{URL::to('third-party/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('third-party/nivo-lightbox/js/nivo-lightbox.min.js')}}"></script>
    <script src="{{URL::to('third-party/owl/js/owl.carousel.js')}}"></script>
    <script src="{{URL::to('third-party/isotope/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{URL::to('third-party/counter-up/js/jquery.counterup.min.js')}}"></script>
    <script src="{{URL::to('third-party/form-validation/js/formValidation.js')}}"></script>
    <script src="{{URL::to('third-party/form-validation/js/framework/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('third-party/waypoint/js/waypoints.min.js')}}"></script>
    <script src="{{URL::to('third-party/wow/js/wow.min.js')}}"></script>
    <script src="{{URL::to('third-party/smooth-scroll/js/smoothScroll.js')}}"></script>
    <script src="{{URL::to('third-party/jquery-parallax/js/jquery.parallax.js')}}"></script>
    <script src="{{URL::to('third-party/jquery-parallax/js/jquery.localscroll.min.js')}}"></script>
    <script src="{{URL::to('third-party/jquery-parallax/js/jquery.scrollTo.js')}}"></script>

<!-- Loading Theme's Scripts -->

<script src="{{URL::to('js/scripts.js')}}"></script>
<!-- CUSTOM NOTIFICATION -->
<script src="{{URL::to('js/iziToast/iziToast.min.js')}}"></script>

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