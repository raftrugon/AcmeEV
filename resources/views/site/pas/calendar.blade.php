@extends('layouts.default')

@section('content')

    <div id="calendar"></div>

@endsection

@section('scripts')
<script>
    $('#calendar').fullCalendar({
        locale: '{{App::getLocale()}}',
        defaultView: 'agendaWeek',
        selectable:true,
        selectOverlap:false,
        eventColor:'#28a745',
        slotDuration:'00:30:00',
        allDaySlot:false,
        weekends:false,
        timeFormat: 'HH:mm',
        height:'auto',
        minTime: '{{$config->getBuildingOpenTime()}}',
        maxTime: '{{$config->getBuildingCloseTime()}}',
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        select: function(startDate,endDate){
            $.post(
                '{{URL::to('administration/calendar/new')}}',
                {start:moment(startDate).format("YYYY-MM-DD HH:mm:ss"),end:moment(endDate).format("YYYY-MM-DD HH:mm:ss"),pas_id:'{{Auth::user()->getId()}}'},
                function(){
                    $('#calendar').fullCalendar('refetchEvents');
                    success('@lang('calendar.availability.success')','@lang('calendar.availability.question'): @lang('global.yes')<br/>@lang('global.start'): '+moment(startDate).format("DD/MM/YYYY HH:mm") + '<br/>@lang('global.end'): ' + moment(endDate).format("DD/MM/YYYY HH:mm"));
                }).fail(function(){
                    error('Error','@lang('calendar.availability.error')');
            });

        },
        eventClick: function(event){
            iziToast.question({
                timeout: false,
                close: false,
                zindex: 999,
                title: '@lang('calendar.question.delete')',
                message: '',
                position: 'center',
                color: '#17a2b8',
                titleColor: 'white',
                iconColor: 'white',
                buttons: [
                    ['<button style="color:white"><b>@lang('global.yes')</b></button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        $.post(
                            '{{URL::to('administration/calendar/delete')}}',
                            {id: event.id},
                            function(){
                                $('#calendar').fullCalendar('refetchEvents');
                                success('@lang('calendar.availability.success')','@lang('calendar.availability.question'): @lang('global.no')<br/>@lang('global.start'): '+moment(event.start).format("DD/MM/YYYY HH:mm") + '<br/>@lang('global.end'): ' + moment(event.end).format("DD/MM/YYYY HH:mm"));
                            }
                        ).fail(function(){
                            error('Error','@lang('calendar.availability.error')');
                        });

                    }, true],
                    ['<button style="color:white">@lang('global.no')</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });
        },
        events: '{{URL::to('administration/calendar/data')}}'
    });
</script>


@endsection