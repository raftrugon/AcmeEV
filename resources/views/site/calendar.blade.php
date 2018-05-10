@extends('layouts.default')

@section('content')

    <div id="calendar"></div>

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
            slotDuration:'01:00:00',
            events: '{{URL::to('calendar/data')}}'
        });

    </script>

@endsection()