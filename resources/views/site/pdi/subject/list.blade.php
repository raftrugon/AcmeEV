@extends('layouts.default')

@section('content')

    @foreach($subjects as $subject)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-0">{{$subject->getName()}} <small>{{$subject->getCode()}}</small>  <a href="{{route('subject-display',['subject'=>$subject->getId()])}}" class="btn btn-outline-primary"> <i class="fas fa-eye"></i></a></h5>
            </div>
        </div>
    @endforeach

@endsection
