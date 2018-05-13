@extends('layouts.default')

@section('content')

    <div class="card-deck">
        @foreach($subjectInstances as $subjectInstance)
            <div class="card">
                <h5 class="card-header">
                    {{$subject->getName()}}
                </h5>
                <div class="card-body">
                    <p class="card-text">
                        <strong>@lang('subject.code'): </strong>
                            {{$subject->getCode()}}</br>
                        <strong>@lang('subject.type'): </strong>
                            @if($subject->getSubjectType()=='OBLIGATORY')
                                @lang('subject.obligatory')</br>
                            @elseif($subject->getSubjectType()=='BASIC')
                                @lang('subject.basic')</br>
                            @elseif($subject->getSubjectType()=='OPTATIVE')
                                @lang('subject.optative')</br>
                            @elseif($subject->getSubjectType()=='EDP')
                                @lang('subject.dt')</br>
                            @endif

                        <strong>@lang('subject.schoolYear'): </strong>
                            {{$subject->getSchoolYear()}}</br>
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
                <button onclick="location.href='{{URL::to('subject/' . $subjectInstance->getId() . '/groups')}}'" class="btn btn-success">
                    @lang('subjectInstance.groups')
                </button>
            </div>
        @endforeach
    </div>

@endsection
