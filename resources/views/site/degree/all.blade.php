@extends('layouts.default')

@section('content')

    <div class="card-deck">
        @foreach($degrees as $degree)
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
         @endforeach
    </div>

@endsection
