@extends('layouts.default')

@section('content')
    <section class="d-flex flex-row-reverse mb-2">
        <div>
            <button class="btn btn-success new-btn">@lang('global.new') <i class="far fa-plus-square"></i></button>
        </div>
    </section>
    <section class="row">
        <div class="card w-100 filters">
            <h5 class="card-header">@lang('global.filters')</h5>
            <div class="card-body">
                <div class="row">
                    @include('global.input',['type'=>'text','id'=>'full_name','label'=>__('attributes.full_name'),'col'=>'4'])
                    @include('global.input',['type'=>'text','id'=>'email','label'=>__('attributes.email'),'col'=>'4'])
                    @include('global.input',['type'=>'text','id'=>'personal_email','label'=>__('attributes.personal_email'),'col'=>'4'])
                </div>
                <div class="row">
                    @include('global.input',['type'=>'text','id'=>'address','label'=>__('attributes.address'),'col'=>'4'])
                    @include('global.input',['type'=>'text','id'=>'phone_number','label'=>__('attributes.phone_number'),'col'=>'4'])
                    @include('global.input',['type'=>'text','id'=>'id_number','label'=>__('attributes.id_number'),'col'=>'4'])
                </div>
                <div class="row">
                    <div class="col-6">
                        @include('global.select',['id'=>'roles','label'=>__('attributes.role'),'col'=>6,'objects'=>$roles,'value'=>'id','display'=>'name','multiselect'=>true])
                    </div>
                    <div class="col-6">
                        @include('global.select',['id'=>'permissions','label'=>__('attributes.permission'),'col'=>6,'objects'=>$permissions,'value'=>'id','display'=>'name','multiselect'=>true])
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="row pt-4 table-responsive">
        <table id="users_table" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>@lang('attributes.full_name')</th>
                    <th>@lang('attributes.email')</th>
                    <th>@lang('attributes.personal_email')</th>
                    <th>@lang('attributes.address')</th>
                    <th>@lang('attributes.phone_number')</th>
                    <th>@lang('attributes.id_number')</th>
                    <th>@lang('attributes.role')</th>
                    <th>@lang('attributes.permission')</th>
                    <th>@lang('global.actions')</th>
                </tr>
            </thead>
        </table>
    </section>

    <div id="modal"></div>

@endsection

@section('scripts')
    <script>
        let timeout;
        $(function() {
            $("#modal").iziModal({
                width:'80%',
                headerColor: 'rgb(136, 160, 185)',
                focusInput: true,
                transitionIn:'bounceInDown',
                transitionOut:'bounceOutUp',
                title:'@lang('global.users_edit')',
                onOpening: function(modal){
                    modal.startLoading();
                    $.get('{{URL::to('users/edit')}}',{id:$('#modal').data('user-id')}, function(data) {
                        $("#modal .iziModal-content").html(data);
                    });
                },
                onOpened: function(modal){
                    $('.selectpicker').selectpicker({container:'body'});
                    $('#create_edit_form').submit(function(e){
                        e.preventDefault();
                        if($(this).valid()) {
                            $.post('{{URL::to('users/save')}}', $('#create_edit_form').serialize(), function (data) {
                                if (data === 'true') {
                                    success('@lang('global.success')', '@lang('users.update.success')');
                                    $('#modal').iziModal('close');
                                    resultsTable.ajax.reload();
                                } else {
                                    error('@lang('global.error')', '@lang('users.update.error')');
                                }
                            });
                        }
                       return false;
                    });
                    $('#create_edit_form').validate({
                       rules: {
                           name: 'required',
                           surname: 'required',
                           email: 'required',
                           personal_email: 'required',
                           address: 'required',
                           phone_number: 'required',
                           id_number: 'required',
                           'roles[]': 'required',
                           'permissions[]': 'required',
                           department_id:{
                               required: function(){
                                   if($.inArray("2",$('[name="roles[]"]').val()) !== -1) return true;
                               }
                           },
                       },
                    });
                    toggleDepartmentSelectVisibility();
                    $('[name="roles[]"]').change(function(){
                        toggleDepartmentSelectVisibility();
                    });

                    modal.stopLoading();
                }
            });

            let resultsTable = $('#users_table').DataTable( {
                "serverSide": true,
                responsive: true,
                search:false,
                "bFilter": false,
                "ajax": {
                    url: '{{URL::to('users/data')}}',
                    cache:false,
                    data: function(d){
                        d.full_name = $('#full_name').val();
                        d.email = $('#email').val();
                        d.personal_email = $('#personal_email').val();
                        d.address = $('#address').val();
                        d.phone_number = $('#phone_number').val();
                        d.id_number = $('#id_number').val();
                        d.roles = $('#roles').val();
                        d.permissions = $('#permissions').val();
                    },
                    type:"get"
                },
                columns: [
                    {data:'full_name'},
                    {data:'email'},
                    {data:'personal_email'},
                    {data:'address'},
                    {data:'phone_number'},
                    {data:'id_number'},
                    {data:'roles'},
                    {data:'permissions'},
                    {data:'actions',class:'text-right'},
                ],
                fnDrawCallback:function(){
                    $('.delete-btn').click(function(){
                        let id = $(this).data('user-id');
                        $.post('{{URL::to('users/delete')}}',{id: id},function(data){
                            if(data === 'true'){
                                success('@lang('global.ok')','@lang('users.delete.success')');
                                resultsTable.ajax.reload();
                            }else{
                                error('@lang('global.error')','@lang('users.delete.error')');
                            }
                        });
                    });
                    $('.edit-btn').click(function(){
                        $('#modal').data('user-id',$(this).data('user-id')).iziModal('open');
                    });
                },
            });

            $('.filters input').keyup(function(){
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    resultsTable.ajax.reload()
                },500);
            });

            $('.filters select').change(function(){
                resultsTable.ajax.reload();
            });

            $('.new-btn').click(function(){
                $('#modal').data('user-id','').iziModal('open');
            });
        });

        function toggleDepartmentSelectVisibility(){
            if($.inArray("2",$('[name="roles[]"]').val()) === -1){
                $('#department_id').closest('.department-col').hide();
                $('#department_id').selectpicker('val','');
            }else{
                $('#department_id').closest('.department-col').show();
            }
        }
    </script>
@endsection