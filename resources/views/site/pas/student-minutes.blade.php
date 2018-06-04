@extends('layouts.default')

@section('content')


    @foreach($academic_years as $minutes)
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 " style="padding: 0 0 40px 0;">
                <div class="card">
                    <h5 class="card-header">@lang('attributes.academic_year') | {{$minutes->first()->getEnrollment->getSubjectInstance->getAcademicYear()}} </h5>
                    <div class="card-body" style="padding: 0; margin:0;">
                        <table class="table " style="padding: 0; margin:0;">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('minute.subject')</th>
                                <th scope="col">@lang('minute.summon')</th>
                                <th scope="col">@lang('minute.qualification')</th>
                                <th scope="col">@lang('minute.status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($minutes as $minute)
                                <tr>
                                    <td>{{$minute->getEnrollment->getSubjectInstance->getSubject->getName()}}</td>
                                    <td>{{$minute->getSummon()}}</td>
                                    <td>
                                        <input class="form-control qualification" type="number" step="0.1" value="{{$minute->getQualification()}}" id="{{$minute->getId()}}"/>
                                    </td>
                                    <td>{{$minute->getStatus()}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <button id="submitButton" class="fixed-bottom btn btn-success position-fixed" style="left:50%;transform:translate(-50%,0);bottom:20px;">
        @lang('minute.updateQualifications')
    </button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.qualification').change(function(){
            $(this).addClass('qualification-changed');
        });
        $('#submitButton').click(function(e){
            e.preventDefault();
            let ids=[];
            let qualifications=[];
            let anyNegative = false;
            $('.qualification-changed').each(function(index){
                ids[index] = $(this).attr('id');
                qualifications[index] = $(this).val();
                if(parseInt(qualifications[index]) < 0){
                    anyNegative=true;
                    $(this).css( "border", "solid 2px #FF0000" );
                }
            });
            if(!anyNegative){
                $.post('{{route('update_minutes')}}',{ids:ids,qualifications:qualifications},
                    function(data) {
                        if(data === 'true'){
                            success('@lang('global.success')','@lang('minute.updated')');
                            window.location.href = '../../../management/student/list';
                        } else {
                            error('@lang('global.error')','@lang('minute.updateFail')');
                        }
                    });
            } else {
                error('@lang('global.error')','@lang('minute.negativeValueFail')');
            }
        });
    </script>
@endsection
