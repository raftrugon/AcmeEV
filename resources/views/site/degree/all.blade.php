@extends('layouts.default')

@section('content')

    <div class="card-deck">
        @foreach($degrees as $degree)
            <div class="col-sm-6 col-md-4 col-xl-3" style="padding-bottom: 40px;">
                <div class="card">
                    <h5 class="card-header">
                        {{$degree->getName()}}
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            @lang('degrees.newStudentsLimit'): {{$degree->getNewStudentsLimit()  }}
                        </p>
                    </div>
                </div>
            </div>
         @endforeach
    </div>

@endsection
