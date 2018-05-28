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
                <div id="accordion{{$loop->iteration}}">
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
                    {
                        degree_id: card_degree.data('degree-id'),
                        school_year: card_year.data('year'),
                        group_number:resource['number'],
                        day:(startDate).format('d'),
                        start:moment(startDate).format("HH:mm:ss"),
                        end:moment(endDate).format("HH:mm:ss")
                    },
                    function(data){
                        let subject_instances,rooms = '';
                        $.each(data['subject_instances'],function(i,val){
                            subject_instances += '<option value="'+val['id']+'">'+val['name']+'</option>';
                        });
                        $.each(data['rooms'],function(i,val){
                            rooms += '<option value="'+val['id']+'">'+val['name']+'</option>';
                        });
                        iziToast.show({
                            theme: 'dark',
                            icon: 'fas fa-calendar',
                            title: '@lang('group.timetable.subject.new')',
                            message: '',
                            position: 'center',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX',
                            timeout:0,
                            layout: 2,
                            iconColor: 'rgb(0, 255, 184)',
                            drag:false,
                            inputs: [
                                ['<label style="color:white;margin-right:5px;" for="subject_instance_id">@lang('attributes.subject')</label><select style="color:white;" id="subject_instance_id">'+subject_instances+'</select><br/>', true],
                                ['<label style="color:white;margin-right:5px;" for="room_id">@lang('attributes.room')</label><select style="color:white;" id="room_id">'+rooms+'</select><br/>', true],
                            ],
                            buttons: [
                                ['<button style="color:white;width:100%"><b>@lang('global.submit')</b></button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                    $.post(
                                        '{{URL::to('group/manage/timetable/new')}}',
                                        {
                                            subject_instance_id: $('#subject_instance_id').val(),
                                            room_id: $('#room_id').val(),
                                            group_number:resource['number'],
                                            day:(startDate).format('d'),
                                            start:moment(startDate).format("HH:mm:ss"),
                                            end:moment(endDate).format("HH:mm:ss")
                                        },
                                        function(data){
                                            if(data === 'true'){
                                                card_year.find('.calendar').fullCalendar('refetchEvents');
                                                success('@lang('global.ok')','@lang('group.timetable.new.success')');
                                            }else{
                                                error('Error','@lang('group.timetable.new.error')');
                                            }
                                        }
                                    ).fail(function(){
                                        error('Error','@lang('group.timetable.new.error')');
                                    });
                                }, true],
                                ['<button style="color:white;width:100%">@lang('global.cancel')</button>', function (instance, toast) {
                                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                }],
                            ],
                            onOpening: function(){
                                // $('.iziToast-inputs select').selectpicker({container:'.iziToast-inputs'});
                                $('.iziToast-inputs').css('float','initial');
                                $('.iziToast-inputs option').css('background-color','#565c70');
                                $('.iziToast-buttons').css('float','initial').addClass('btn-group').addClass('d-flex');
                            }
                        });
                    }
                );
            },
            events: {
                url: '{{URL::to('group/manage/timetable/events')}}',
                data: function(){
                    return {
                        degree_id: card_degree.data('degree-id'),
                        school_year: card_year.data('year'),
                    }
                }
            }
        });
    });
    </script>
@endsection