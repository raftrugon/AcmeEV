@extends('layouts.default')

@section('content')
    <div class="container pt-3">
        <div class="card text-center">
            <div class="card-header">
                @lang('inscription.results-title')
            </div>
            <div class="card-body">
                <table id="results_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('attributes.name')</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="card-footer text-muted">
                <form id="results_form">
                    <div class="form-row align-items-end">
                        @include('global.input',['type'=>'text','id'=>'id_number','label'=>__('attributes.id_number'),'col'=>5])
                        @include('global.input',['type'=>'password','id'=>'password','label'=>__('attributes.password'),'col'=>5])
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-primary">@lang('global.submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            let resultsTable = $('#results_table').DataTable( {
                "serverSide": true,
                responsive: true,
                sortable:false,
                "bPaginate": false,
                "bFilter": false,
                "bInfo":false,
                "ordering":false,
                "ajax": {
                    url: '{{URL::to('inscription/results/data')}}',
                    cache:false,
                    data: function(d){
                        d.id_number = $('#id_number').val();
                        d.password = $('#password').val();
                    },
                    type:"post",
                    dataSrc: function(response){
                        if($('#id_number').val() !== '' && $('#password').val() !== '' && response.data.length === 0){
                            error('@lang('global.error')','@lang('inscription.result.accept.credentials')');
                        }
                        return response.data;
                    }
                },
                columns: [
                    {data:'priority',"width":"10%"},
                    {data:'name',"width":"70%"},
                    {data:'accepted',"width":"20%"},
                ],
                fnDrawCallback:function(){
                    $('.agree-btn').click(function(){
                       $.post('{{URL::to('inscription/results/agree')}}',{id_number: $('#id_number').val(),password: $('#password').val()},function(data){
                           if(data === 'true'){
                               success('@lang('global.ok')','@lang('inscription.result.accept.success')');
                               resultsTable.ajax.reload();
                           }else if(data === 'credentials'){
                               error('@lang('global.error')','@lang('inscription.result.accept.credentials')');
                           }else{
                               error('@lang('global.error')','@lang('inscription.result.accept.error')');
                           }
                       });
                    });
                }
            });

            $('#results_form button').click(function(){
                if($('#results_form').valid()) resultsTable.ajax.reload();
            });

            $('#results_form').validate({
                rules:{
                    id_number:'required',
                    password:'required',
                },
                messages:{
                    id_number:"{{__('validation.required',['attribute'=>__('attributes.id_number')])}}",
                    password:"{{__('validation.required',['attribute'=>__('attributes.password')])}}",
                }
            })
        });
    </script>
@endsection