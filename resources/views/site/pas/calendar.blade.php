@extends('layouts.default')

@section('content')

    <div id="calendar"></div>

@endsection

@section('scripts')
<script>
    $('#calendar').fullCalendar({
        defaultView: 'agendaWeek',
        selectable:true,
        select: function(startDate,endDate){
            alert(startDate + ' ' + endDate);
        }
    });
</script>


@endsection