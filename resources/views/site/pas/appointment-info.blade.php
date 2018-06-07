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
<div class="col-sm-9" style="overflow-y:auto;max-height: 96vh;">
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
                                    <strong>
                                        @if(is_null($appointment->getIdNumber())) {{$appointment->getStudent->getFullName()}} <span class="badge badge-success"> @lang('global.student') </span>
                                        @elseif(is_null($appointment->degrees)) {{$appointment->getIdNumber()}} <span class="badge badge-danger"> @lang('global.anonymous') </span>
                                        @else {{$appointment->full_name}} <span class="badge badge-warning"> @lang('global.new_ingress') </span>
                                        @endif
                                    </strong>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$startTimeLabel.$loop->index}}" class="collapse" aria-labelledby="heading{{$startTimeLabel.$loop->index}}" data-parent="#accordion{{$startTimeLabel}}">
                            @if(is_null($appointment->id_number))
                                <div class="card">
                                    <div class="card-body" >
                                        <div class="row">
                                            @php($student = $appointment->getStudent)
                                            {{--    Personal Data    --}}
                                            <div class="card border-info bg-light" style="width: 100%; margin: 10px;">
                                                <div class="card-header border-info text-center" >@lang('inscription.personal_data')</div>
                                                <div class="card-body" >
                                                    <p class="card-text"><strong>@lang('attributes.name'):</strong> {{ $student->getFullName() }} </p>
                                                    <p class="card-text"><strong>@lang('attributes.degree'):</strong> {{ $student->getDegree->getName() }} </p>
                                                    <p class="card-text"><strong>@lang('attributes.id_number'):</strong> {{ $student->getIdNumber() }} </p>
                                                    <p class="card-text"><strong>@lang('attributes.address'):</strong> {{ $student->getAddress() }} </p>
                                                    <p class="card-text"><strong>@lang('attributes.phone_number'):</strong> {{ $student->getPhoneNumber() }} </p>
                                                    <p class="card-text"><strong>@lang('attributes.email'):</strong> {{ $student->getEmail() }} </p>
                                                </div>
                                            </div>
                                            {{--    Enrollments    --}}
                                            @php(
                                            $enrollments = $student->getEnrollments()
                                            ->join('subject_instances','enrollments.subject_instance_id', '=', 'subject_instances.id')
                                            ->join('subjects','subject_instances.subject_id', '=', 'subjects.id')
                                            ->orderBy('subject_instances.academic_year', 'DESC')
                                            ->select('subjects.*','subject_instances.academic_year as academic_year')
                                            ->get()
                                            )
                                            @if(!$enrollments->isEmpty())
                                                <div class="card border-info bg-light " style="width: 100%; margin: 10px;">
                                                    <div class="card-header border-info text-center">@lang('global.enrollments')</div>
                                                    <div class="card-body" style="margin: 0; padding: 0;">
                                                        <table class="table" style="margin: 0; padding: 0;">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">@lang('attributes.academic_year')</th>
                                                                <th scope="col">@lang('attributes.name')</th>
                                                                <th scope="col">@lang('attributes.school_year')</th>
                                                                <th scope="col">@lang('attributes.type')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($enrollments as $enrollment)
                                                                <tr>
                                                                    <td>{{$enrollment->academic_year}}</td>
                                                                    <td>{{$enrollment->name}}</td>
                                                                    <td>{{$enrollment->school_year}}</td>
                                                                    <td>{{$enrollment->subject_type}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                            {{--    Minutes    --}}
                                            @php(
                                            $minutes = $student->getEnrollments()
                                            ->join('subject_instances','enrollments.subject_instance_id', '=', 'subject_instances.id')
                                            ->join('subjects','subject_instances.subject_id', '=', 'subjects.id')
                                            ->join('minutes','enrollments.id', '=', 'minutes.enrollment_id')
                                            ->orderBy('subject_instances.academic_year', 'DESC')
                                            ->select('minutes.*', 'subjects.name as subject_name','subject_instances.academic_year as academic_year')
                                            ->get()
                                            )
                                            @if(!$minutes->isEmpty())
                                                <div class="card border-info bg-light " style="width: 100%; margin: 10px;">
                                                    <div class="card-header border-info text-center">@lang('global.minutes')</div>
                                                    <div class="card-body" style="margin: 0; padding: 0;">
                                                        <table class="table" style="margin: 0; padding: 0;">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">@lang('attributes.academic_year')</th>
                                                                <th scope="col">@lang('attributes.subject_name')</th>
                                                                <th scope="col">@lang('attributes.summon')</th>
                                                                <th scope="col">@lang('attributes.status')</th>
                                                                <th scope="col">@lang('attributes.qualification')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($minutes as $minute)
                                                                <tr>
                                                                    <td>{{$minute->academic_year}}</td>
                                                                    <td>{{$minute->subject_name}}</td>
                                                                    <td>{{$minute->summon}}</td>
                                                                    <td>
                                                                        @if(!$minute->status)
                                                                            @lang('attributes.open')
                                                                        @else
                                                                            @lang('attributes.closed')
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$minute->qualification}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @else
                            @php($options = isset($appointment->degrees) ? explode(',',$appointment->degrees) : [])
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-deck">
                                        <div class="card border-info bg-light">
                                            <div class="card-header border-info text-center">@lang('inscription.personal_data')</div>
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
                                            <div class="card-header border-info text-center">@lang('inscription.choices')</div>
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