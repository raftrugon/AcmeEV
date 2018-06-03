@extends('layouts.default')

@section('content')

<div style="padding: 20px 0 0 0;">
    <div class="card">
        <h5 class="card-header bg-secondary text-white">@lang('global.studentList')</h5>

        <div class="card-body" style="padding: 0; margin:0;">
            <table class="table table-striped" style="padding: 0; margin:0;">
                <thead class="table-primary">
                <tr>
                    <th scope="col">@lang('global.idNumber')</th>
                    <th scope="col">@lang('global.fullName')</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{$student->getIdNumber()}}</td>
                        <td>{{$student->getFullName()}}</td>
                        <td>
                            <a href="{{URL::to('management/minute/'.$student->getId().'/all')}}" class="btn btn-primary">
                                @lang('minute.updateQualifications')
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
