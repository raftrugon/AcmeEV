@extends('layouts.default')

@section('content')

    <form id="degree_form" action="{{URL::to('degree/save')}}" method="post" novalidate>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('degrees.new.title')</Strong>
                    </div>
                    <div class="card-body">
                        @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name'),'vue'=>true])
                        @include('global.input',['type'=>'text','id'=>'new_students_limit','name'=>'new_students_limit','label'=>__('attributes.new_students_limit'),'vue'=>true])
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

        $('#degree_form').validate({
            rules:{
                name : required,
                new_students_limit : required
            },

            messages:{
                name: "{{__('validation.required',['attribute'=>'attributes.name'])}}",
                new_students_limit: "{{__('validation.required',['attribute'=>__('new_students_limit')])}}",
            }
        });
    </script>
@endsection