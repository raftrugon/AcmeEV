@extends('layouts.default')

@section('content')
<div class="container pt-3">
    @unless(Auth::check())
    <div class="alert alert-success text-center" role="alert">
        <strong> @lang('inscription.homealert.title') </strong> &emsp;@lang('inscription.homealert.link')
    </div>
    <div class="alert alert-success text-center" role="alert">
        <strong> Lista de adjudicaciones disponible </strong> Pulsa <a href="{{URL::to('inscription/results')}}">aquí</a> para ver tus adjudicaciones
    </div>
    @endunless
</div>
@endsection
