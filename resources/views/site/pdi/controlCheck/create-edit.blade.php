@extends('layouts.default')

@section('content')

    <form id="controlCheck_form" action="{{URL::to('control_check/save')}}" method="post" novalidate>
        {{csrf_field()}}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('controlCheck.new')</Strong>
                    </div>
                    <div class="card-body">
                        @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name')])
                        @include('global.input',['type'=>'text','id'=>'description','name'=>'description','label'=>__('attributes.description')])
                        @include('global.select',['id'=>'rooms','objects'=>$rooms,'value'=>'id','display'=>'name','label'=>__('controlCheck.rooms')])
                        @include('global.input',['type'=>'date','id'=>'date','name'=>'date'])
                        <button>@lang('global.submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        /*function submitForm(){
            $('#degree_form').submit();
        };*/

        $('#department_form').validate({
            rules:{
                name : required,
                website : required
            },

            messages:{
                name: "{{__('validation.required',['attribute'=>'attributes.name'])}}",
                new_students_limit: "{{__('validation.required',['attribute'=>__('website')])}}",
            }
        });
    </script>
@endsection