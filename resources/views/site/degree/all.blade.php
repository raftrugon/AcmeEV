@extends('layouts.default')

@section('content')




            <div class="card border-primary" style="background-color: #6c6b6d;margin-bottom: 40px;">
                <div class="card-body">
                    <button onclick="location.href='{{URL::to('management/degree/new')}}'" class="btn btn-success">@lang('degrees.create')</button>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" >@lang('degrees.activeEdit')</button>
                </div>
            </div>


        <div class="row">
            <div class="card-deck">
                @foreach($degrees as $degree)
                    <div class="col-md-6 col-lg-4 col-xl-3" style="padding-bottom: 40px;">
                        <div class="card">
                            <h5 class="card-header">
                                {{$degree->getName()}}
                            </h5>
                            <div class="card-body">
                                <p class="card-text">
                                    @lang('degrees.newStudentsLimit'): {{$degree->getNewStudentsLimit()  }}
                                </p>
                                <div class="collapse multi-collapse">
                                    <button onclick="location.href='{{URL::to('management/degree/' . $degree->getId() . '/edit')}}'" class="btn btn-success">@lang('degrees.edit')</button>
                                    <button onclick="location.href='{{URL::to('management/degree/delete')}}'" class="btn btn-danger">@lang('degrees.delete')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                 @endforeach
            </div>
        </div>

@endsection
