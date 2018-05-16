@extends('layouts.default')

@section('content')

    <div class="card bg-light mb-3">
        <h1 class="text-center">
            {{$department->getName()}}
        </h1>
        <p class="text-center">
            <strong>@lang('department.code'): </strong> {{$department->getCode()}}</br>
            <strong>@lang('department.url'): </strong>
                <a href="{{$department->getWebsite()}}">
                    {{$department->getWebsite()}}
                </a>
        </p>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-sm-6 card bg-light">
                <h1 class="text-center">
                    @lang('department.subjects')
                </h1>
                <table class="table table-bordered bg-white">
                    @foreach($subjects as $subject)
                        <tr>
                            <td class="card">
                                <div class="card_header">
                                    <h3>
                                        {{$subject->getName()}}</br>
                                    </h3>
                                </div>
                                    <p class="card-text ml-4">
                                        <strong>@lang('subject.code'): </strong>
                                        <small class="font-weight-light">
                                            {{$subject->getCode()}}</br>
                                        </small>
                                        <strong>@lang('subject.type'): </strong>
                                        @if($subject->getSubjectType()=='OBLIGATORY')
                                            <small class="font-weight-light">
                                                @lang('subject.obligatory')</br>
                                            </small>
                                        @elseif($subject->getSubjectType()=='BASIC')
                                            <small class="font-weight-light">
                                                @lang('subject.basic')</br>
                                            </small>
                                        @elseif($subject->getSubjectType()=='OPTATIVE')
                                            <small class="font-weight-light">
                                                @lang('subject.optative')</br>
                                            </small>
                                        @elseif($subject->getSubjectType()=='EDP')
                                            <small class="font-weight-light">
                                                @lang('subject.dt')</br>
                                            </small>
                                        @endif

                                        <strong>@lang('subject.schoolYear'): </strong>
                                        <small class="font-weight-light">
                                            {{$subject->getSchoolYear()}}</br>
                                        </small>
                                        <strong>@lang('subject.semester'): </strong>
                                        @if($subject->getSemester()==null)
                                            <small class="font-weight-light">
                                                @lang('subject.annual')
                                            </small>
                                        @elseif($subject->getSemester()==false)
                                            <small class="font-weight-light">
                                                @lang('subject.first')
                                            </small>
                                        @elseif($subject->getSemester()==true)
                                            <small class="font-weight-light">
                                                @lang('subject.second')
                                            </small>
                                        @endif
                                    </p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-sm-6 card bg-light">
                <h1 class="text-center">
                    @lang('department.pdis')
                </h1>
                <table class="table table-bordered bg-white">
                    @foreach($pdis as $pdi)
                        <tr>
                            <td>
                                <strong>
                                    {{$pdi->getFullName()}}</br>
                                </strong>
                                <small class="font-weight-light">
                                    {{$pdi->getEmail()}}
                                </small>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection
