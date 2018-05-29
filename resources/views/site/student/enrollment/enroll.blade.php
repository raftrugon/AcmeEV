@extends('layouts.default')

@section('content')

    <form id="enrollment_form" action="{{URL::to('student/enrollment/post-enroll')}}" method="post" novalidate>
        {{ csrf_field() }}
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card border-info">
                    <div class="card-header text-center">
                        <Strong>@lang('enrollment.enroll.title')</Strong>
                    </div>
                    <div class="card text-white bg-info" style="max-width: 100%; margin: 6px 0;">
                        <div class="card-body">
                            <p class="card-text">@lang('enrollment.enroll.description')</p>
                        </div>
                    </div>
                    @foreach($subjects_years as $subjects)
                        <div class="card border-dark" style="max-width: 100%; margin: 6px 0;">
                            <div class="card-header bg-dark text-white">@lang('attributes.school_year')
                                | {{$subjects->first()->getSchoolYear()}}</div>
                            <div class="card-body" style="padding: 0;margin: 0;">
                                @foreach($subjects as $subject)
                                    <div class="card border-dark" style="max-width: 100%;padding: 2px;margin: 1px;">
                                        <div class="card-body text-dark" style="padding: 2px;margin: 0;">
                                            <div class="form-check">
                                                <input class="form-check-input" name="enrollment[]" type="checkbox" value="{{$subject->getId()}}" id="{{$subject->getId()}}">
                                                <strong><label class="form-check-label">{{$subject->getName()}}</label></strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <button>@lang('global.submit')</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">


    </script>
@endsection