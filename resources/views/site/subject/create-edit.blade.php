@extends('layouts.default')

@section('content')

    <form id="subject_form" action="{{URL::to('management/subject/save')}}" method="post" novalidate>
        {{csrf_field()}}
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('subject.edit')</Strong>
                    </div>
                    <div class="card-body">
                        @if(isset($subject))
                            <input type="hidden" name="degree" value="{{$degree->getId()}}"/>
                            <input type="hidden" name="id" value="{{$subject->getId()}}"/>
                            @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name'),'value'=>$subject->getName()])
                            @include('global.input',['type'=>'number','id'=>'school_year','name'=>'school_year','label'=>__('attributes.school_year'),'value'=>$subject->getSchoolYear()])
                            <div class="form-group">
                                <label for="select">@lang('attributes.semester')</label>
                                <select class="form-control" id="selectSemester" name="semester">
                                    <option value="0" @if($subject->getSemester()===0) selected @endif>@lang('subject.first')</option>
                                    <option value="1" @if($subject->getSemester()===1) selected @endif>@lang('subject.second')</option>
                                    <option value="2" @if(is_null($subject->getSemester())) selected @endif>@lang('subject.annual')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select">@lang('attributes.type')</label>
                                <select class="form-control" id="selectType" name="type">
                                    <option value="0" @if($subject->getSubjectType()==='OBLIGATORY') selected @endif>@lang('subject.obligatory')</option>
                                    <option value="1" @if($subject->getSubjectType()==='BASIC') selected @endif>@lang('subject.basic')</option>
                                    <option value="2" @if($subject->getSubjectType()==='OPTATIVE') selected @endif>@lang('subject.optative')</option>
                                    <option value="3" @if($subject->getSubjectType()==='EDP') selected @endif>@lang('subject.dt')</option>
                                </select>
                            </div>
                            @if($subject->isActive()===1)
                                @include('global.input',['type'=>'checkbox','value'=>1,'id'=>'active','name'=>'active','checked'=>'checked','label'=>__('subject.active'),'texto'=>''])
                            @else
                                @include('global.input',['type'=>'checkbox','value'=>1,'id'=>'active','name'=>'active','label'=>__('subject.active'),'texto'=>''])
                            @endif
                            @include('global.select',['id'=>'department','objects'=>$departments,'value'=>'id','display'=>'name','label'=>__('subject.department'),'selectedOption'=>$subject->getDepartment->getId()])
                            @include('global.select',['id'=>'coordinator','objects'=>$subject->getDepartment->getPDIs,'value'=>'id','display'=>'full_name','label'=>__('subject.coordinator'),'selectedOption'=>$subject->getCoordinator->getId()])
                        @else
                            <input type="hidden" name="degree" value="{{$degree->getId()}}"/>
                            <input type="hidden" name="id" value="0"/>
                            @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name')])
                            @include('global.input',['type'=>'number','id'=>'school_year','name'=>'school_year','label'=>__('attributes.school_year')])
                            <div class="form-group">
                                <label for="select">@lang('attributes.semester')</label>
                                <select class="form-control" id="selectSemester" name="semester">
                                    <option value="0">@lang('subject.first')</option>
                                    <option value="1">@lang('subject.second')</option>
                                    <option value="2">@lang('subject.annual')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select">@lang('attributes.type')</label>
                                <select class="form-control" id="selectType" name="type">
                                    <option value="0">@lang('subject.obligatory')</option>
                                    <option value="1">@lang('subject.basic')</option>
                                    <option value="2">@lang('subject.optative')</option>
                                    <option value="3">@lang('subject.dt')</option>
                                </select>
                            </div>
                            @include('global.input',['type'=>'checkbox','value'=>1,'id'=>'active','name'=>'active','checked'=>'checked','label'=>__('subject.active'),'texto'=>''])
                            @include('global.select',['id'=>'department','objects'=>$departments,'value'=>'id','display'=>'name','label'=>__('subject.department')])
                            @include('global.select',['id'=>'coordinator','objects'=>$pdis,'value'=>'id','display'=>'full_name','label'=>__('subject.coordinator')])
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
        $(function() {
            $('#subject_form').validate({
                rules: {
                    name: 'required',
                    school_year: 'required'
                },

                messages: {
                    name: "{{__('validation.required',['attribute'=>'attributes.name'])}}",
                    school_year: "{{__('validation.required',['attribute'=>__('school_year')])}}",
                }
            });

            $('#department').change(function () {
                let department_id = $(this).selectpicker('val');
                $(this).parent().parent().nextAll().find('.selectpicker').each(function (index,element) {
                    let nextSelectpicker = element;
                    $.get('{{URL::to('department/get-pdis')}}',{id:department_id},function(data){
                        $(nextSelectpicker).html("");
                        $.each(data,function(key,value){
                            $(nextSelectpicker).append('<option value="'+value['id']+'">'+value['name']+' '+ value['surname']+'</option>');
                        });
                        if(index === 0) $(nextSelectpicker).prop('disabled', '');
                        else $(nextSelectpicker).prop('disabled', true);
                        $(nextSelectpicker).selectpicker('refresh');
                        $('.'+$(nextSelectpicker).attr('id')+' span').html(' - ');
                    });
                });
            });
        });
    </script>
@endsection