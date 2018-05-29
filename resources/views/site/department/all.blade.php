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
                            <strong>@lang('department.url'): </strong> <a href="{{$department->getWebsite()}}">{{$department->getWebsite()}}</a>
                        </p>
                        @can('manage')
                        <a href="{{URL::to('pdi/department/edit/'.$department->getId())}}" class="btn btn-success">
                            @lang('global.edit')
                        </a>
                        @endcan
                    </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>


    <a href="{{ URL::to('pdi/department/edit') }}" id="submitButton" class="col-sm-3 fixed-bottom btn btn-success position-fixed" style="left:50%;transform:translate(-50%,0);bottom:20px;">
        @lang('department.new')
    </a>

@endsection
