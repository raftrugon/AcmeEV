@extends('layouts.default')

@section('content')



    <div class="row justify-content-center">
        <div class="col-md-10">

            <form id="announcement_form" action="{{URL::to('pdi/announcement/save')}}" method="post"
                  novalidate>
                {{ csrf_field() }}
                <div class="row align-items-end">

                    @include('global.input',['col'=>'12','type'=>'text','id'=>'title','name'=>'title','label'=>__('attributes.title'),'placeholder'=>__('placeholder.text'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getTitle() : null ])
                    @include('global.input',['col'=>'12','type'=>'text','id'=>'body','name'=>'body','label'=>__('attributes.body'),'placeholder'=>__('placeholder.text'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getBody() : null ])
                    @include('global.input',['col'=>'12','type'=>'date','id'=>'creation_moment','name'=>'creation_moment','label'=>__('attributes.creation_moment'),'placeholder'=>__('placeholder.date'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getCreationMoment() : null ])
                </div>

                @isset($announcement)
                    <input type="hidden" name="id" id="id" value="{{$announcement->getId()}}">
                @endisset
                <div class="card-footer border-info p-0">
                    <button type="submit" class="btn btn-success btn-block rounded-0">@lang('global.submit')</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#announcement_form').validate();
    </script>
@endsection