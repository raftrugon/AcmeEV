@extends('layouts.default')

@section('content')

    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1" style="padding: 0 0 40px 0;">
        <div id="accordion">
            @php ($first = 1)
            @php ($index = 1)
            @foreach($academic_years as $enrollments)
                <div class="card">
                    <div class="card-header" id="heading{{$index}}">
                        <h5 class="mb-0">
                            @if($first == 1)
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$index}}"
                                        aria-expanded="true" aria-controls="collapse{{$index}}">
                                    @lang('attributes.academic_year') | {{$enrollments->first()->getSubjectInstance->getAcademicYear()}}
                                </button>

                            @else
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$index}}"
                                        aria-expanded="false" aria-controls="collapse{{$index}}">
                                    @lang('attributes.academic_year') | {{$enrollments->first()->getSubjectInstance->getAcademicYear()}}
                                </button>
                            @endif
                        </h5>
                    </div>

                    @if($first == 1)
                        @php ($first = 0)
                        <div id="collapse{{$index}}" class="collapse show" aria-labelledby="heading{{$index}}" data-parent="#accordion">
                    @else
                        <div id="collapse{{$index}}" class="collapse" aria-labelledby="heading{{$index}}" data-parent="#accordion">
                    @endif

                            <div class="card-body">
                                @foreach($enrollments as $enrollment)
                                    @php ($subject = $enrollment->getSubjectInstance->getSubject)
                                    @if($enrollment->getSubjectInstance->getAcademicYear() == ($actual_academic_year))
                                        <a href="{{URL::to('subject/'.$subject->getId())}}">
                                            <div class="card border-primary mb-3">
                                                <div class="card-body text-primary">
                                                    <h5 class="card-title">{{$subject->getName()}}</h5>
                                                    <p class="card-text"><strong>@lang('attributes.department'): </strong>{{$subject->getDepartment->getName()}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <div class="card border-dark mb-3">
                                            <div class="card-body text-dark">
                                                <h5 class="card-title">{{$subject->getName()}}</h5>
                                                <p class="card-text"><strong>@lang('attributes.department'): </strong>{{$subject->getDepartment->getName()}}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                </div>

                @php ($index++)
            @endforeach
        </div>
     </div>



@endsection
