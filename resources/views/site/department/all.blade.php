@extends('layouts.default')

@section('content')

    <div class="card-deck">
        @foreach($departments as $department)
            <div class="card">
                <h5 class="card-header">
                    {{$department->getName()}}
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
