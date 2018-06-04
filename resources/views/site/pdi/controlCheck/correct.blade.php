@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-body" style="padding: 0; margin:0;">
            <table class="table " style="padding: 0; margin:0;">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">@lang('global.idNumber')</th>
                    <th scope="col">@lang('minute.qualification')</th>
                </tr>
                </thead>
                <tbody>

                @foreach($controlCheckInstances as $cci)
                    <tr>
                        <td>{{$cci->getStudent->getIdNumber()}}</td>
                        <td>
                            <input class="form-control qualification" type="number" step="0.1" value="{{$cci->getQualification()}}" id="{{$cci->getId()}}"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
            $('.qualification-changed').each(function(index){
                ids[index] = $(this).attr('id');
                qualifications[index] = $(this).val();
            });
            $.post('{{route('update_controlCheck_qualifications')}}',{ids:ids,qualifications:qualifications},
                function(data) {
                    if(data === 'true'){
                        success('@lang('global.success')','@lang('controlCheck.updated')');
                        location.reload();
                    } else {
                        error('@lang('global.error')','@lang('controlCheck.updateFail')');
                    }
                });
        });
    </script>
@endsection
