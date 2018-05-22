@extends('layouts.default')

@section('content')

    <form id="controlCheck_form" action="{{URL::to('pdi/control_check/save')}}" method="post" novalidate>
        {{csrf_field()}}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('controlCheck.new')</Strong>
                    </div>
                    <div class="card-body">
                        @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name')])
                        @include('global.input',['type'=>'text','id'=>'description','name'=>'description','label'=>__('controlCheck.description')])
                        @include('global.select',['id'=>'room','objects'=>$rooms,'value'=>'id','display'=>'number','label'=>__('controlCheck.rooms')])
                        @include('global.input',['type'=>'date','id'=>'date','name'=>'date','label'=>__('controlCheck.date'),'placeholder'=>__('placeholder.date')])
                        @include('global.input',['type'=>'checkbox','value'=>1,'id'=>'isSubmittable','name'=>'isSubmittable','checked'=>'checked','label'=>__('controlCheck.isSubmittable'),'texto'=>''])
                        @include('global.input',['type'=>'number','id'=>'weight','name'=>'weight','min'=>'0','max'=>'1','step'=>'0.1','label'=>__('controlCheck.weight')])
                        @include('global.input',['type'=>'number','id'=>'minimumMark','name'=>'minimumMark','label'=>__('controlCheck.minimumMark')])
                        <input type="hidden" value="{{$subjectInstance->getId()}}" id="subjectInstance" name="subjectInstance"/>
                        <button>@lang('global.submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('.time').datetimepicker({
            format: 'HH:mm:ss'
        });
        $('#controlCheck_form').submit(function(){
            if(!$('#controlCheck_form').valid()) return false;
        });
        $('#controlCheck_form').validate({
            rules:{
                name : 'required',
                description : 'required',
                rooms : 'required',
                date : 'required',
                weight : 'required',
                minimumMark : 'required',
            },

            messages:{
                name: "{{__('validation.required',['attribute'=>__('name')])}}",
                description : "{{__('validation.required',['attribute'=>__('desciption')])}}",
                rooms : "{{__('validation.required',['attribute'=>__('rooms')])}}",
                date : "{{__('validation.required',['attribute'=>__('date')])}}",
                weight : "{{__('validation.required',['attribute'=>__('weight')])}}",
                minimumMark : "{{__('validation.required',['attribute'=>__('minimumMark')])}}"
            }
        });
    </script>
@endsection