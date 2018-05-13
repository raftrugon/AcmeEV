@extends('layouts.default')

@section('styles')
<style>
    body{
        max-height:100vh;
        overflow-y: hidden;
    }
    #ltr_list{
        direction:rtl;
    }
    #ltr_list div{
        direction:ltr;
    }

</style>
@endsection

@section('content')
<div class="row">
<div id="ltr_list" class="col-sm-3" style="overflow-y:auto;max-height: 96vh;">
    <div id="tab-list" class="list-group" role="tablist">
        @foreach($appointments as $date => $appointmentTime)
        <a class="list-group-item d-flex justify-content-between align-items-center @if($date == $now->format('H:i')) active @endif
        @if(sizeof($appointmentTime)==0 && $date != $now->format('H:i')) list-group-item-secondary @else list-group-item-action @endif"
        @if(sizeof($appointmentTime)==0 && $date != $now->format('H:i')) style="cursor:not-allowed"
        @else  data-toggle="list" href="#{{str_replace(':','',$date)}}" role="tab" @endif
        >
            {{$date}}
            @if(sizeof($appointmentTime)>0)
            <span class="badge badge-primary badge-pill">{{sizeof($appointmentTime)}}</span>
            @endif
        </a>
        @endforeach
    </div>
</div>
<div class="col-sm-9">
    <div class="tab-content">
        @foreach($appointments as $date => $appointmentTime)
            @php($startTimeLabel = str_replace(':','',$date))
            <div class="tab-pane @if($date == $now->format('H:i')) active @endif" id="{{$startTimeLabel}}" role="tabpanel">
                <div id="accordion{{$startTimeLabel}}">
                    @forelse($appointmentTime as $appointment)
                    <div class="card">
                        <div class="card-header p-0" id="heading{{$startTimeLabel.$loop->index}}">
                            <h5 class="mb-0">
                                <button class="btn btn-block btn-light text-primary btn-lg collapsed" data-toggle="collapse" data-target="#collapse{{$startTimeLabel.$loop->index}}" aria-expanded="false" aria-controls="collapse{{$startTimeLabel.$loop->index}}">
                                    <strong>@if(is_null($appointment->getIdNumber())) {{$appointment->getStudent->getFullName()}} <span class="badge badge-success"> @lang('global.student') </span> @elseif(is_null($appointment->degrees)) {{$appointment->getIdNumber()}} <span class="badge badge-danger"> @lang('global.anonymous') </span> @else {{$appointment->full_name}} <span class="badge badge-warning"> @lang('global.new_ingress') </span> @endif</strong>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$startTimeLabel.$loop->index}}" class="collapse" aria-labelledby="heading{{$startTimeLabel.$loop->index}}" data-parent="#accordion{{$startTimeLabel}}">
                            @if(is_null($appointment->id_number))

                            @else
                            @php($options = isset($appointment->degrees) ? explode(',',$appointment->degrees) : [])
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-deck">
                                        <div class="card border-info bg-light">
                                            <div class="card-header border-info">@lang('inscription.personal_data')</div>
                                            <div class="card-body">
                                                <p class="card-text"><strong>@lang('attributes.name'):</strong> {{ $appointment->full_name }} </p>
                                                <p class="card-text"><strong>@lang('attributes.id_number'):</strong> {{ $appointment->id_number }} </p>
                                                <p class="card-text"><strong>@lang('attributes.address'):</strong> {{ $appointment->address }} </p>
                                                <p class="card-text"><strong>@lang('attributes.phone_number'):</strong> {{ $appointment->phone_number }} </p>
                                                <p class="card-text"><strong>@lang('attributes.email'):</strong> {{ $appointment->email }} </p>
                                                <p class="card-text"><strong>@lang('attributes.grade'):</strong> {{ $appointment->grade }} </p>
                                            </div>
                                        </div>
                                        <div class="card border-info bg-light">
                                            <div class="card-header border-info">@lang('inscription.choices')</div>
                                            <div class="card-body">
                                                @forelse($options as $option)
                                                @php($attribute = explode('<>',$option))
                                                <p class="card-text"><strong>@lang('global.option',['number'=>$attribute[2]]):</strong> <a> {{$attribute[1]}} </a></p>
                                                @empty
                                                    @lang('calendar.no-info')
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            @lang('calendar.none-for-now')
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>
@endsection

@section('scripts')

@endsection