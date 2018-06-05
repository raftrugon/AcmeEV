@extends('layouts.default')

@section('content')

    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 card bg-light mb-3 card" style="padding: 0;">
        <h1 class="text-center card-header bg-dark text-white">
            {{$degree->getName()}}
        </h1>
            <p class="text-left card-body" style="padding: 20px;margin:0;">
                <strong>@lang('degrees.code'): </strong> {{$degree->getCode()}}</br>
                <strong>@lang('degrees.newStudentsLimit'): </strong>{{$degree->getNewStudentsLimit()}}
            </p>
    </div>


    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 card bg-light" style="padding: 0 0 40px 0;">
        <h2 class="text-center" style="padding-top: 13px; margin-bottom: 0">@lang('department.subjects')</h2>

        @foreach($school_years as $subjects)
            @php ($index = 0)

            <div style="padding: 20px 0 0 0;">
                <div class="card">
                    <h5 class="card-header bg-secondary text-white">@lang('attributes.school_year')
                        | {{$subjects->first()->getSchoolYear()}} </h5>
                    <div class="card-body" style="padding: 0; margin:0;">
                        <table class="table table-striped" style="padding: 0; margin:0;">
                            <thead class="table-primary">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('attributes.name')</th>
                                <th scope="col">@lang('attributes.department')</th>
                                <th scope="col">@lang('attributes.semester')</th>
                                <th scope="col">@lang('attributes.type')</th>
                                <th scope="col">@lang('attributes.code')</th>
                                <th scope="col">@lang('attributes.active')</th>
                                @if($actual_state < 3 || $actual_state == 10)
                                    @can('manage')
                                        <th></th>
                                    @endcan
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                @php ($index++)
                                <tr @if(!$subject->isActive()) class="bg-danger text-light" @endif>
                                    <th scope="row">{{$index}}</th>
                                    <td>{{$subject->getName()}}</td>
                                    <td><a href="{{URL::to('department/' . $subject->getDepartment->getId() . '/display')}}">{{$subject->getDepartment->getName()}}</a></td>
                                    <td>
                                        @if (is_null($subject->getSemester()))
                                            @lang('subject.annual')
                                        @elseif($subject->getSemester() == 1)
                                            @lang('subject.second')
                                        @elseif($subject->getSemester() == 0)
                                            @lang('subject.first')
                                        @endif
                                    </td>
                                    <td>
                                        @if($subject->getSubjectType()=='OBLIGATORY')
                                            <small class="font-weight-light">
                                                @lang('subject.obligatory')
                                            </small>
                                        @elseif($subject->getSubjectType()=='BASIC')
                                            <small class="font-weight-light">
                                                @lang('subject.basic')
                                            </small>
                                        @elseif($subject->getSubjectType()=='OPTATIVE')
                                            <small class="font-weight-light">
                                                @lang('subject.optative')
                                            </small>
                                        @elseif($subject->getSubjectType()=='EDP')
                                            <small class="font-weight-light">
                                                @lang('subject.dt')
                                            </small>
                                        @endif
                                    </td>
                                    <td><small class="font-weight-light">{{$subject->getCode()}}</small></td>
                                    <td>
                                        @if($subject->isActive())
                                            @lang('global.yes')
                                        @else
                                            @lang('global.no')
                                        @endif
                                    </td>
                                    @if($actual_state < 3 || $actual_state == 10)
                                        @can('manage')
                                            <td><a href="{{URL::to('management/subject/'.$degree->getId().'/edit/'.$subject->getId())}}" class="btn btn-primary">@lang('global.edit')</a></td>
                                        @endcan
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @if($actual_state < 3 || $actual_state == 10)
        @can('manage')
            <a href="{{URL::to('management/subject/'.$degree->getId().'/edit')}}" id="submitButton" class="fixed-bottom btn btn-success position-fixed col-sm-3" style="left:50%;transform:translate(-50%,0);bottom:20px;">
                @lang('subject.add')
            </a>
        @endcan
    @endif



@endsection
