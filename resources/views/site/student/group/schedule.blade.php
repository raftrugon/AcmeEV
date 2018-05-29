@extends('layouts.default')

@section('styles')
    <style>
        .fc-time-grid .fc-event{
            margin:2px!important;
            border-width:2px;
        }
        .tooltip{
            white-space: pre-line!important;
        }
    </style>
@endsection

@section('content')
<div id="calendar"></div>
@include('site.student.group.exchange')
{{--<button class="btn btn-primary btn-block mt-4 print-btn">@lang('global.download') <i class="far fa-file-pdf"></i></button>--}}
@endsection

@section('scripts')
    <script>
    $(function(){
        $('#calendar').fullCalendar({
            locale: '{{App::getLocale()}}',
            defaultView: 'agendaWeek',
            selectable: false,
            selectOverlap: false,
            slotDuration: '00:30:00',
            allDaySlot: false,
            weekends: false,
            slotEventOverlap: false,
            eventColor: '#D2D5D8',
            eventBorderColor: '#17a2b8',
            eventTextColor: '#17a2b8',
            displayEventTime: false,
            height: 'auto',
            minTime: '{{\App\SystemConfig::first()->getBuildingOpenTime()}}',
            maxTime: '{{\App\SystemConfig::first()->getBuildingCloseTime()}}',
            groupByDateAndResource: true,
            resources: {
                url: '{{URL::to('group/student/schedule/resources')}}',
                type: 'GET',
            },
            resourceText: function (resource) {
                return '@lang('attributes.school_year'): ' + resource['id'];
            },
            eventRender: function (event, element) {
                element.attr('data-toggle', 'tooltip');
                element.attr('title', event.group + '\n' + event.teacher);

            },
            eventAfterAllRender: function (view) {
                $('[data-toggle="tooltip"]').tooltip();
            },
            eventClick(event, jsEvent, view) {
                $.get('{{URL::to('group/student/exchange/create')}}', {group_id: event.group_id}, function (data) {
                    $('.source-card .card-header').html('@lang('group.number'): ' + data['source_number']);
                    $('.source-card .card-subtitle').html(data['source_subject']);
                    $('.target-card .card-subtitle').html(data['source_subject']);
                    $('.source-card .card-text').html(data['source_period_times']);
                    $('.source-card').data('group-id',data['source_id']);
                    $('.target-card .selectpicker').html(data['target_options']).selectpicker('refresh');
                    $('.submit-btn').removeClass('text-warning').removeClass('text-success')
                    $('#exchangeModal').modal('show');
                });
            },
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            events: '{{URL::to('group/student/schedule/events')}}',
        });
        {{--$('.print-btn').click(function(){--}}
        {{--location.href = '{{URL::to('group/student/schedule/print')}}';--}}
        {{--});--}}
        $('.target-card .selectpicker').change(function(){
            let val = $(this).val();
            $.get('{{URL::to('group/student/exchange/data-and-availability')}}',{group_id:val},function(data){
                $('.target-card .card-text').html(data['target_period_times']);
                if(data['availability'] === true) $('.submit-btn').addClass('text-success');
                else $('.submit-btn').addClass('text-warning')
            });
        });
        $('.submit-btn').click(function(){
           if($('.target-card .selectpicker').val() === '') return false;
           $.post('{{URL::to('group/student/exchange/save')}}',{source_id: $('.source-card').data('group-id'),target_id:$('.target-card .selectpicker').val()},function(data){
               $('#calendar').fullCalendar('refetcEvents');
           });
        });
    });
    </script>
@endsection