@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="card-deck">
            @foreach($announcements as $announcement)
                <div class="col-md-6 col-lg-4 col-xl-3" style="padding-bottom: 40px;">
                    <div class="card">
                        <h5 class="card-header">
                            {{$announcement->getTitle()}}
                        </h5>
                        <div class="card-body">
                            <p class="card-text">
                                @lang('degrees.newStudentsLimit'): {{$announcement->getbody()  }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
