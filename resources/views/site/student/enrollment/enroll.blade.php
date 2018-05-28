@extends('layouts.default')

@section('content')

    <form id="enrollment_form" action="{{URL::to('student/enrollment/save')}}" method="post" novalidate>
        {{ csrf_field() }}
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card border-info">
                    <div class="card-header text-center">
                        <Strong>@lang('enrollment.new')</Strong>
                    </div>
                    @foreach($subjects_years as $subjects)
                        <div class="card text-white bg-secondary" style="max-width: 100%; padding-bottom: 10px">
                            <div class="card-header">@lang('attributes.school_year')
                                | {{$subjects->first()->getSchoolYear()}}</div>
                            <div class="card-body" style="padding: 0;margin: 0;">
                                @foreach($subjects as $subject)
                                    <div class="card border-dark" style="max-width: 100%;padding: 2px;margin: 2px;">
                                        <div class="card-body text-dark" style="padding: 2px;margin: 0;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <label class="form-check-label">{{$subject->getName()}}</label>
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