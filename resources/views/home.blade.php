@extends('layouts.default')

@section('content')
<div class="container pt-3">
    @unless(Auth::check())
    <div class="alert alert-success text-center" role="alert">
        <strong> @lang('inscription.homealert.title') </strong> &emsp;@lang('inscription.homealert.link')
    </div>
    @endunless
</div>
@endsection
