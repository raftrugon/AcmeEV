@extends('layouts.default')

@section('content')

    @foreach($subjects as $subject)
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div>
                <h5 class="card-title mb-0">{{$subject->getName()}} <small>{{$subject->getCode()}}</small> </h5>
                <p class="card-text" style="font-size: small;padding-left:2em;">
                    <strong>@lang('subject.code'): </strong>
                    {{$subject->getCode()}}<br/>
                    <strong>@lang('subject.type'): </strong>
                    @if($subject->getSubjectType()=='OBLIGATORY')
                    @lang('subject.obligatory')<br/>
                    @elseif($subject->getSubjectType()=='BASIC')
                    @lang('subject.basic')<br/>
                    @elseif($subject->getSubjectType()=='OPTATIVE')
                    @lang('subject.optative')<br/>
                    @elseif($subject->getSubjectType()=='EDP')
                    @lang('subject.dt')<br/>
                    @endif

                    <strong>@lang('subject.schoolYear'): </strong>
                    {{$subject->getSchoolYear()}}<br/>
                    <strong>@lang('subject.semester'): </strong>
                    @if($subject->getSemester()==null)
                        @lang('subject.annual')
                    @elseif($subject->getSemester()==false)
                        @lang('subject.first')
                    @elseif($subject->getSemester()==true)
                        @lang('subject.second')
                    @endif
                </p>
                </div>
                <div>
                    @if(Auth::id() === $subject->getCoordinator->getId())
                    <button onclick="location.href='{{URL::to('pdi/subject/' . $subject->getId() . '/instances')}}'" class="btn btn-success">
                        @lang('subject.instances')
                    </button>
                    @endif
                    <a href="{{route('subject-display',['subject'=>$subject->getId()])}}" class="btn btn-outline-primary"> <i class="fas fa-eye"></i></a>
                </div>
            </div>
        </div>
    @endforeach

@endsection
