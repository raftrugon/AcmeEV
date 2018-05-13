<!DOCTYPE html>
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
    <!-- FullCalendar css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/fullcalendar.min.css')}}">



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
    <div id="content" class="p-4 @if(Session::get('sidebar','true') == 'true') aside @endif">
        <!-- Header -->
            {{--@include('layouts.default-header')--}}
        <!-- END HEADER -->
        @yield('content')
    </div>
</div>
<!-- #PAGE FOOTER -->
@include('layouts.default-footer')
<!-- END FOOTER -->
@includeWhen(!Auth::check(),'auth.login')
<!-- End of Page Content -->


<!-- jQuery -->
<script src="{{asset('js/jQuery.js')}}"></script>
<!-- Moment-->
<script src="{{asset('js/moment.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- CUSTOM NOTIFICATION -->
<script src="{{asset('js/iziToast.min.js')}}"></script>
<!-- Smart Wizard -->
<script src="{{asset('js/smartWizard.js')}}"></script>
<!-- Bootstrap Select -->
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>
<!-- jQuery Validator -->
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<!-- jQuery Validator Config-->
<script src="{{asset('js/global/validator-config.js')}}"></script>
<!-- Vue-->
<script src="{{asset('js/vue.js')}}"></script>
<!-- Calendar-->
<script src="{{asset('js/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('js/fullcalendar/es.js')}}"></script>

<!-- CUSTOM Scripts -->
<script src="{{asset('js/custom.js')}}"></script>

<!--AJAX CONFIG-->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    function toggleSidebar(){
        $('#content').toggleClass('aside');
        $('#sidebar').toggleClass('show');
        $('.sidebar-btn').toggleClass('show');
        $.post('{{URL::to('sidebar')}}',{show: $('#sidebar').hasClass('show')});
    }

    @unless(Auth::check())
    $(function(){
        $('#login_form').submit(function(){
            $.post(
                '{{route('login')}}',
                $('#login_form').serialize()
            ).done(function(data){
                if(data === 'true'){
                    location.href = '{{route('home')}}';
                }
            }).fail(function(data,textStatus,jqXHR){
                if(jqXHR === 'Unprocessable Entity'){
                    error('@lang('global.error')','@lang('auth.failed')');
                    $('#login-error').html('<strong>@lang('auth.failed')</strong>');
                    $('#login-email').addClass('is-invalid');
                    $('#login-password').addClass('is-invalid');
                }else if(jqXHR === 'Too Many Requests'){
                    console.log(data);
                    error('@lang('global.error')',data.responseJSON.errors.email[0]);
                    $('#login-error').html('<strong>'+data.responseJSON.errors.email[0]+'</strong>');
                    $('#login-email').addClass('is-invalid');
                    $('#login-password').addClass('is-invalid');
                }
            });
            return false;
        });
    });
    @endunless
</script>

@yield('scripts')
</body>

</html>