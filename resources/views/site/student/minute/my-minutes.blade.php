@extends('layouts.default')

@section('content')
    @foreach($academic_years as $minutes)
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 " style="padding: 0 0 40px 0;">
                <div class="card">
                    <h5 class="card-header">@lang('attributes.academic_year') | {{$minutes->first()->getEnrollment->getSubjectInstance->getAcademicYear()}} </h5>
                    <div class="card-body" style="padding: 0; margin:0;">
                        <table class="table " style="padding: 0; margin:0;">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('minute.subject')</th>
                                <th scope="col">@lang('minute.summon')</th>
                                <th scope="col">@lang('minute.qualification')</th>
                                <th scope="col">@lang('minute.status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($minutes as $minute)
                                <tr>
                                    <td>{{$minute->getEnrollment->getSubjectInstance->getSubject->getName()}}</td>
                                    <td>{{$minute->getSummon()}}</td>
                                    <td>{{$minute->getQualification()}}</td>
                                    <td>{{$minute->getStatus()}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection