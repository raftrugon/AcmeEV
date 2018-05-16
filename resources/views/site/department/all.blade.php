@extends('layouts.default')

@section('content')

    <div class="card-deck">
        @foreach($departments as $department)
            <div class="card">
                <h5 class="card-header">
                    <a href="{{URL::to('department/'.$department->getId().'/display')}}">{{$department->getName()}}</a>
                </h5>
                <div class="card-body">
                    <p class="card-text">
                        <strong>@lang('department.code'): </strong> {{$department->getCode()  }}</br>
                        <strong>@lang('department.url'): </strong>
                                {{$department->getWebsite()}}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

@endsection
