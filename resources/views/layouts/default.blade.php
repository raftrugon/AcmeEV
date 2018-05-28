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
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/scheduler.min.css')}}">
    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/datatables/dataTables.bootstrap4.min.css')}}">
    <!-- Dropify css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/dropify.min.css')}}">
    <!-- DateTimePIcker css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/datetimepicker.min.css')}}">
    <!-- Chat css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/chat.css')}}">




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
        <!-- Notifications -->
        @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>@lang('global.success')</strong> {{Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>@lang('global.error')</strong> {{Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- End Notifications -->
        @yield('content')
    </div>
</div>
<!-- Messaging Service -->
@includeWhen(Auth::check(),'layouts.chat')
<!-- End of messaging -->
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
<script src="{{asset('js/fullcalendar/scheduler.min.js')}}"></script>
<!-- Datatables -->
<script src="{{asset('js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Dropify-->
<script src="{{asset('js/dropify.min.js')}}"></script>
<!-- DateTimePicker-->
<script src="{{asset('js/datetimepicker.min.js')}}"></script>
@auth
<!-- Chat-->
<script src="{{asset('js/chat.js')}}"></script>
@endauth
<!-- Push Notifications-->
<script src="{{asset('js/notifications/push.min.js')}}"></script>


<!-- CUSTOM Scripts -->
<script src="{{asset('js/custom.js')}}"></script>

<!--AJAX CONFIG-->
<script>
    const urlNewMessage = '{{URL::to('chat/message/new')}}';
    const urlNewChat = '{{URL::to('chat/new')}}';
    const urlRetrieveMessages = '{{URL::to('chat/message/un-read')}}';
    const groupsPopoverTitle = '@lang('chat.groups')';
    const urlLoadChats = '{{URL::to('chat/load')}}';
    const urlCloseChat = '{{URL::to('chat/close')}}';
    const urlOpenChat = '{{URL::to('chat/open')}}';
    const urlMinChat = '{{URL::to('chat/min')}}';
    //variable to store new chat id (levels out bug with double change event firing)
    let lastCreatedChat = '';

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

    @guest
    $(function(){
        $('#login_form').submit(function(){
            $.post(
                '{{route('login')}}',
                $('#login_form').serialize()
            ).done(function(data){
                if(data === 'true'){
                    location.href = '{{URL::full()}}';
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
    @endguest

    @auth
        {{--@if(!is_null(Session::get('conversation.opened')))--}}
            $(function(){loadChats({{Session::get('conversation.'.Auth::id().'.opened')}});});
        {{--@endif--}}
    @endauth
</script>


@yield('scripts')
</body>

</html>