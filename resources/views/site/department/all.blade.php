@extends('layouts.default')

@section('content')

    <div class="card-deck">
        <div class="row">
            @foreach($departments as $department)
                <div class="col-lg-6" style="padding: 20px;">
                <div class="card">
                    <h4 class="card-header">
                        <a href="{{URL::to('department/'.$department->getId().'/display')}}"><strong>{{$department->getName()}}</strong></a>
                    </h4>
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
