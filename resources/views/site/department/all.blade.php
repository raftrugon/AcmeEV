@extends('layouts.default')

@section('content')

    <div class="card-deck">
        <div class="row">
            @foreach($departments as $department)
                <div class="col-md-6" style="padding: 20px;">
                <div class="card">
                    <h5 class="card-header">
                        <a href="{{URL::to('department/'.$department->getId().'/display')}}">{{$department->getName()}}</a>
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>@lang('department.code'): </strong> {{$department->getCode()  }}</br>
                            <strong>@lang('department.url'): </strong> {{$department->getWebsite()}}
                        </p>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
