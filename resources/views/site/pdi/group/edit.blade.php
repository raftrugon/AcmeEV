@extends('layouts.default')

@section('content')
    <input type="hidden" name="groupId" id="groupId" value="{{$group->getId()}}">
    <h1 align="center">
        <strong>
            @lang('group.theoryLecturer')
        </strong>
    </h1>
    <select class="selectpicker w-100" data-live-search="true" id="select1">
        <option value=""> @lang('global.choose_one')</option>
        @foreach($department_lecturers as $lecturer)
            <option value="{{$lecturer->getId()}}" @if($theory_lecturer == $lecturer) selected="true" @endif>
                {{$lecturer->getFullName()}}
            </option>
        @endforeach
    </select>
    <h1 align="center" class="mt-3">
        <strong>
            @lang('group.practiceLecturer')
        </strong>
    </h1>
    <select class="selectpicker w-100" data-live-search="true" id="select2">
        <option value=""> @lang('global.choose_one')</option>
        @foreach($department_lecturers as $lecturer)
            <option value="{{$lecturer->getId()}}" @if($practice_lecturer == $lecturer) selected="true" @endif>
                {{$lecturer->getFullName()}}
            </option>
        @endforeach
    </select>
    <button class="btn btn-success btn-block mt-3" id="submitButton" >@lang('global.submit')</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#submitButton').click(function(e){
            e.preventDefault();
            let groupId = $('#groupId').val();
            let lecturers = [];
            lecturers[0] = $('#select1').selectpicker('val');
            lecturers[1] = $('#select2').selectpicker('val');
            $.post('{{route('edit_group_lecturers',['group'=>$group->getId()])}}',{lecturers:lecturers,group:groupId},function(data){
                if(data==='true'){
                    success('@lang('global.success')','@lang('group.successMessage')');
                    window.location.replace('{{URL::to('pdi/subject/list')}}');
                } else {
                    error('@lang('global.error')','@lang('group.commitError')');
                }
            });
        });
    </script>
@endsection