@extends('layouts.default')

@section('content')

    @can('manage')
        <div class="card border-primary" style="background-color: #6c6b6d;margin-bottom: 40px;">
            <div class="card-body">
                <button onclick="location.href='{{URL::to('management/degree/new')}}'"
                        class="btn btn-success">@lang('degrees.create')</button>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse"
                        aria-expanded="false">@lang('degrees.activeEdit')</button>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="card-deck">
            @foreach($degrees as $degree)
                <div class="col-lg-6 " style="padding-bottom: 40px;">
                    <div class="card">
                        <h5 class="card-header">
                            <a href="{{URL::to('degree/'.$degree->getId().'/display')}}">{{$degree->getName()}}</a>
                        </h5>
                        <div class="card-body">
                            <p class="card-text">
                                @lang('degrees.newStudentsLimit'): {{$degree->getNewStudentsLimit()  }}
                            </p>
                            @role('admin')
                            <button class="btn btn-danger deleteButton" id="{{$degree->getId()}}">
                                @lang('degrees.delete')
                            </button>
                            @endrole
                            @can('manage')
                                <div class="collapse multi-collapse">
                                    <button onclick="location.href='{{URL::to('management/degree/' . $degree->getId() . '/edit')}}'"
                                            class="btn btn-success">@lang('degrees.edit')</button>
                                    <button class="btn btn-danger deleteButton" id="{{$degree->getId()}}">@lang('degrees.delete')</button>
                                    @if ($degree->canCreateSubjectInstances())
                                        <button onclick="location.href='{{URL::to('management/degree/'. $degree->getId() .'/add-next-year-subjects')}}'"
                                                class="btn btn-success">@lang('degrees.nextYear')</button>
                                    @endif
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('.deleteButton').click(function (e) {
            e.preventDefault();
            $.post('{{route('delete_degree')}}', {id: $(this).attr('id')}, function (data) {
                if (data === 'true') {
                    success('@lang('global.success')', '@lang('degree.successDelete')');
                    window.location.replace('{{URL::to('degree/all')}}');
                } else {
                    error('@lang('global.error')', '@lang('degree.deleteFailed')');
                }
            });
        });
    </script>
@endsection