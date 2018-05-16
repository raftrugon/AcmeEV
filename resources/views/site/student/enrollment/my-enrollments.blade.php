@extends('layouts.default')

@section('content')

    <div class="row">

            @foreach($academic_years as $enrollments)
            @php ($index = 0)

                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 " style="padding: 0 0 40px 0;">
                    <div class="card">
                        <h5 class="card-header">@lang('attributes.academic_year') | {{$enrollments->first()->getSubjectInstance->getAcademicYear()}} </h5>
                        <div class="card-body" style="padding: 0; margin:0;">
                            <table class="table " style="padding: 0; margin:0;">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('attributes.name')</th>
                                    <th scope="col">@lang('attributes.department')</th>
                                    <th scope="col">@lang('attributes.school_year')</th>
                                    <th scope="col">@lang('attributes.semester')</th>
                                    <th scope="col">@lang('attributes.code')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($enrollments as $enrollment)
                                    @php ($subject = $enrollment->getSubjectInstance->getSubject)
                                    @php ($index++)
                                    <tr>
                                        <th scope="row">{{$index}}</th>
                                        <td>{{$subject->getName()}}</td>
                                        <td>{{$subject->getDepartment->getName()}}</td>
                                        <td>{{$subject->getSchoolYear()}}</td>
                                        <td>
                                        @if ($subject->getSemester() == 0)
                                            @lang('attributes.semester_first')
                                        @elseif($subject->getSemester() == 1)
                                            @lang('attributes.semester_second')
                                        @else
                                            @lang('attributes.semester_annual')
                                        @endif
                                        </td>
                                        <td>{{$subject->getCode()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


        @endforeach

    </div>

@endsection
