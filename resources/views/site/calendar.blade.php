@extends('layouts.default')

@section('content')

    <div id="calendar" class="student-calendar"></div>

@endsection

@section('scripts')
    <script>
        $('#calendar').fullCalendar({
            locale: '{{App::getLocale()}}',
            defaultView: 'agendaWeek',
            selectable: true,
            selectOverlap: false,
            eventColor: '#28a745',
            timeFormat: 'HH:mm',
            displayEventTime: false,
            slotEventOverlap:false,
            slotDuration:'00:30:00',
            weekends:false,
            allDaySlot:false,
            height:'auto',
            minTime: '{{$config->getSecretariatOpenTime()}}',
            maxTime: '{{$config->getSecretariatCloseTime()}}',
            events: '{{URL::to('calendar/data')}}',
            eventOrder: 'tooltip',
            eventRender: function(event, element) {
                element.attr('data-toggle','tooltip');
                element.attr('title',event.tooltip);
                element.css('cursor','pointer');
                if(!event.is_available){
                    element.css('background-color','#dc3545');
                    element.css('cursor','not-allowed');
                }
                if(event.mine){
                    element.css('background-color','#007bff');
                    element.css('cursor','pointer');
                }
            },
            eventAfterAllRender: function(view){
                $('[data-toggle="tooltip"]').tooltip();
            },
            eventClick: function(event){
                if(!event.is_available && !event.mine){
                    return false;
                }
                let title,goText,cancelText = '';
                if(!event.mine){
                    title =  '@lang('calendar.appointment.question.new')';
                    goText = '@lang('calendar.go')';
                    cancelText = '@lang('global.cancel')';
                }else{
                    title = '@lang('calendar.appointment.question.delete')';
                    goText = '@lang('global.cancel')';
                    cancelText = '@lang('global.no')';
                }
                iziToast.question({
                    timeout: false,
                    close: false,
                    zindex: 999,
                    title: title,
                    message: '@lang('calendar.appointment.moment'): '+moment(event.real_start).format("DD/MM/YYYY HH:mm"),
                    position: 'center',
                    color: '#17a2b8',
                    titleColor: 'white',
                    iconColor: 'white',
                    drag:false,
                    @guest
                    inputs: [
                        ['<label for="id_number">@lang('attributes.id_number')</label><input required type="text" id="id_number">', true],
                    ],
                    @endguest
                    buttons: [
                        ['<button style="color:white"><b>'+goText+'</b></button>', function (instance, toast) {
                            @guest
                            if($('#id_number').val() === '') return false;
                            @endguest
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            $.post(
                                '{{URL::to('calendar/update')}}',
                                {start: event.real_start @guest ,id_number:$('#id_number').val() @endguest},
                                function(data){
                                    $('#calendar').fullCalendar('refetchEvents');
                                    if(data === 'true') {
                                        success('@lang('calendar.appointment.success')','@lang('calendar.appointment.moment'): ' + moment(event.real_start).format("DD/MM/YYYY HH:mm"));
                                    }else if(data === 'false'){
                                        error('Error','@lang('calendar.appointment.error')');
                                    }else{
                                        error('Error',data);
                                    }
                                }
                            ).fail(function(){
                                error('Error','@lang('calendar.appointment.error')');
                            });

                        }, true],
                        ['<button style="color:white">'+cancelText+'</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }],
                    ]
                });
            }
        });

    </script>

@endsection()