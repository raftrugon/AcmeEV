@extends('layouts.default')

@section('content')

    <form id="degree_form" action="{{URL::to('management/degree/save')}}" method="post" novalidate>
        {{ csrf_field() }}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('degrees.new.title')</Strong>
                    </div>
                    <div class="card-body">
                        @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name'), 'value'=>isset($degree) ? $degree->getName() : null ])
                        @include('global.input',['type'=>'text','id'=>'new_students_limit','name'=>'new_students_limit','label'=>__('attributes.new_students_limit'), 'value'=>isset($degree) ? $degree->getNewStudentsLimit() : null])
                        @isset($degree)
                            <input type="hidden" name="id" id="id" value="{{$degree->getId()}}">
                        @endisset
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

$('#degree_form').validate({
rules:{
    name : {required:true},
    new_students_limit :{
        min: 1}
},

messages:{
    name: "{{__('validation.required',['attribute'=>'attributes.name'])}}",
    new_students_limit: {
        required: "{{__('validation.required',['attribute'=>'attributes.new_students_limit'])}}",
        min: "{{__('validation.min.numeric',['attribute'=>__('attributes.grade'),'min'=>1])}}",
    },
}
});
</script>
@endsection