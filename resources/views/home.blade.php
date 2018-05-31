@extends('layouts.default')

@section('content')
    <div class="container-fluid pt-3">

        @unless(Auth::check())
            @if($actual_state == 0)
                <div class="alert alert-success text-center" role="alert">
                    <strong> @lang('inscription.homealert.title') </strong> &emsp;@lang('inscription.homealert.link')
                </div>
            @endif
            @if($actual_state == 1 || $actual_state == 2)
                <div class="alert alert-success text-center" role="alert">
                    <strong> @lang('global.adjudication.title') </strong> &emsp;@lang('global.adjudication.link')
                </div>
            @endif
        @endunless
        @if(Auth::check())
            @if(Auth::user()->can('current') || Auth::user()->can('new'))
                @if($actual_state == 3)
                    @if($can_student_enroll)
                        <div class="alert alert-success text-center" role="alert">
                            <strong> @lang('global.enroll.title') </strong> &emsp;@lang('global.enroll.link')
                        </div>
                    @endif
                @endif
            @endif
        @endif

        <div class="card">
            <img src="{{asset('img/mainpage.png')}}" class="card-img-top" alt="Card image cap">
            <div class="card-body">
                <h1 class="card-title text-center font-weight-bold">@lang('global.welcome-heading')</h1>
                <p class="card-text text-justify">@lang('global.welcome-body')</p>
            </div>
        </div>
    </div>
@endsection
