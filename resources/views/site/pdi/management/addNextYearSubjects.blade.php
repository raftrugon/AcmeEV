@extends('layouts.default')

@section('content')
    @for($i=1; $i<=$degree->getSubjects()->max('school_year');$i++)
        <h1 align="center">
            <strong>
                @lang('degrees.school_year') {{$i}}
            </strong>
        </h1>
        <ul class="list-group">
            @foreach($degree->getSubjects()->where('school_year',$i)->get() as $subject)
                <li class="list-group-item subject" data-selected=0 data-subject-id="{{$subject->getId()}}">
                    <a>{{$subject->getName()}}</a>
                </li>
            @endforeach
        </ul>
    @endfor
    <button class="btn btn-success"></button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.subject').click(function(e){
            e.preventDefault();
            if($(this).data('selected')===0){
                $(this).data('selected',1);
                $(this).addClass("active");
            } else {
                $(this).data('selected',0);
                $(this).removeClass("active");
            }
        });
    </script>
@endsection