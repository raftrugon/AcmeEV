@extends('layouts.default')

@section('content')
<div id="accordion">
    @foreach($degrees as $degree)
    <div class="card card-degree my-2" data-degree-id="{{$degree->getId()}}">
        <div class="card-header" id="heading{{$loop->iteration}}">
            <h5 class="mb-0">
                <button class="btn btn-link subject-link" data-toggle="collapse" data-target="#collapse{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse{{$loop->iteration}}">
                   {{$degree->getName()}}
                </button>
            </h5>
        </div>

        <div id="collapse{{$loop->iteration}}" class="collapse" aria-labelledby="heading{{$loop->iteration}}" data-parent="#accordion">
            <div class="card-body">
                @foreach(range(1,$degree->getSubjects()->max('school_year')) as $year)
                    <div class="card card-year my-2" data-year="{{$year}}">
                        <div class="card-header" id="heading{{$loop->parent->iteration}}_{{$loop->iteration}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link year-link" data-toggle="collapse" data-target="#collapse{{$loop->parent->iteration}}_{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse{{$loop->parent->iteration}}_{{$loop->iteration}}">
                                    {{$year}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$loop->parent->iteration}}_{{$loop->iteration}}" class="collapse" aria-labelledby="heading{{$loop->parent->iteration}}_{{$loop->iteration}}" data-parent="#accordion{{$loop->parent->iteration}}">
                            <div class="card-body">
                                <div class="calendar"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
    <script>
    $('.year-link').click(function(){
        let card_year = $(this).closest('.card-year');
        let card_degree = $(this).closest('.card-degree');
        card_year.find('.calendar').fullCalendar({
            locale: '{{App::getLocale()}}',
            defaultView: 'agendaWeek',
            selectable: true,
            selectOverlap: false,
            eventColor: '#28a745',
            slotDuration: '00:30:00',
            allDaySlot: false,
            weekends: false,
            timeFormat: 'HH:mm',
            height: 'auto',
            minTime: '{{\App\SystemConfig::first()->getBuildingOpenTime()}}',
            maxTime: '{{\App\SystemConfig::first()->getBuildingCloseTime()}}',
            groupByDateAndResource: true,
            resources: {
                url: '{{URL::to('group/manage/timetable/resources')}}',
                type: 'GET',
                data: {degree_id: card_degree.data('degree-id'),year: card_year.data('year')},
            },
            resourceText: function(resource){
              return '@lang('group.number')'+resource['number'];
            },
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            select: function(startDate,endDate,jsEvent,view,resource){
                $.get(
                    '{{URL::to('group/manage/timetable/data')}}',
                    {group_id:resource['id']},
                    function(data){
                        $('#calendar').fullCalendar('refetchEvents');
                        success('@lang('calendar.availability.success')','@lang('calendar.availability.question'): @lang('global.yes')<br/>@lang('global.start'): '+moment(startDate).format("DD/MM/YYYY HH:mm") + '<br/>@lang('global.end'): ' + moment(endDate).format("DD/MM/YYYY HH:mm"));
                    }).fail(function(){
                    error('Error','@lang('calendar.availability.error')');
                });

            },
        });
    });
    </script>
@endsection