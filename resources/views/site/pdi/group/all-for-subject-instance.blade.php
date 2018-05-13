@extends('layouts.default')

@section('content')

<div class="card-deck">
    @foreach($groups as $group)
    <div class="card">
        <h5 class="card-header text-center">
            @lang('group.number'){{$group->getNumber()}}
        </h5>
        <button onclick="location.href='{{URL::to('group/' . $group->getId() . '/edit')}}'" class="btn btn-success">
            @lang('group.manage')
        </button>
    </div>
    @endforeach
</div>

@endsection
