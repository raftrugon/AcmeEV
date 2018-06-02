@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-header text-center">
            <h1>@lang('global.terms')</h1>
        </div>
        <div class="card-body">
            @lang('global.termsBody')
        </div>
    </div>
@endsection