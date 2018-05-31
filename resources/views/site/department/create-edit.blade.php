@extends('layouts.default')

@section('content')

    <form id="degree_form" action="{{URL::to('pdi/department/save')}}" method="post" novalidate>
        {{csrf_field()}}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('department.new')</Strong>
                    </div>
                    <div class="card-body">
                        @if(isset($department))
                            <input type="hidden" name="id" value="{{$department->getId()}}"/>
                            @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name'),'value'=>$department->getName()])
                            @include('global.input',['type'=>'text','id'=>'website','name'=>'website','label'=>__('attributes.website'),'value'=>$department->getWebsite()])
                        @else
                            <input type="hidden" name="id" value="0"/>
                            @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name')])
                            @include('global.input',['type'=>'text','id'=>'website','name'=>'website','label'=>__('attributes.website')])
                        @endif
                        <button class="btn btn-success">@lang('global.submit')</button>
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