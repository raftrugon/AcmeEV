@extends('layouts.default')

@section('content')
<div class="container pt-3">
    <div class="alert alert-success" role="alert">
        <strong> ¡Plazos de nuevo ingreso abiertos! </strong> &emsp; Pulse <a href="{{URL::to('inscription/new')}}" class="alert-link">aquí</a> para rellenar su solicitud.
    </div>
</div>
@endsection
