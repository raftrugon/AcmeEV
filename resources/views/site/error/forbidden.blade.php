@extends('layouts.default')

@section('content')
    <div class="container-fluid pt-3">
        <div class="card">
            <div class="card-header row align-items-center" style="padding: 0; margin: 0; background-color: #ffb2b2">
                <i class="fas fa-ban col-3" style="font-size:250px; padding: 60px"></i>
                <div class="col-8" style="margin-left: 40px; padding: 110px 40px;font-size: 25px">
                    <h1 class="card-title ">@lang('error.forbidden.title')</h1>
                    <p class="card-text text-justify" style="padding-top: 30px">@lang('error.forbidden.description')</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-3">
        <div class="card align-items-center" style="background-color: #f9f9f9">
            <div class="row" style="padding: 0; margin: 0; ">
                <i class="fas fa-home" style="font-size:40px; padding: 25px"></i>
                <a style="padding: 20px;padding-top: 30px;" href="{{URL::to('/')}}"><h4 class="card-title">@lang('error.forbidden.home')</h4></a>
            </div>
        </div>
    </div>
@endsection
