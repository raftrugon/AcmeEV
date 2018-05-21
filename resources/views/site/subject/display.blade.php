@extends('layouts.default')

@section('styles')

<style>
    .card:hover input[type=text].form-control-plaintext{
        color:white;
    }
    .card:hover .input-group-prepend i{
        color:white;
    }
    .card input[name=name].form-control-plaintext{
        font-size:1.25em;
        color:#007bff;
        font-weight:500;
    }
    .card input[name=description].form-control-plaintext{
        color:#007bff;
    }
    .card input[type=text][disabled]{
        background-color:initial;
        cursor:pointer;
    }
</style>

@endsection

@section('content')

    <div class="jumbotron py-1">
        <h1 class="display-4">{{$subject->getName()}}</h1>
        <p class="lead">{{$subject->getCode()}}</p>
    </div>
    <nav>
        <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">@lang('subject.announcements')</a>
            <a class="nav-item nav-link" id="nav-filesystem-tab" data-toggle="tab" href="#nav-filesystem" role="tab" aria-controls="nav-filesystem" aria-selected="false">@lang('filesystem.tab')</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active pt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        </div>
        <div class="tab-pane fade pt-3" id="nav-filesystem" role="tabpanel" data-id-current="" aria-labelledby="nav-filesystem-tab">
            @include('site.subject.includes.filesystem')
        </div>
        <div class="tab-pane fade pt-3" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

        </div>
    </div>




@endsection


@section('scripts')

    <script>
        function loadContent(folderId){
            $.ajax({
                url: '{{route('filesystem.data')}}',
                data: {subjectId: '{{$subject->getId()}}', folderId: folderId},
                beforeSend: function(){
                    $('#filesystem_content').html('');
                    $('#loader').show();
                },
                success: function (data) {
                    $('#nav-filesystem').data('id-current',folderId);
                    let backBtn = $('#back_button');
                    if (folderId === null){
                        backBtn.css('visibility','hidden');
                        $('#new_file_modal_btn').hide();
                    }
                    else {
                        backBtn.data('id', data.parentId);
                        backBtn.css('visibility','visible');
                        $('#new_file_modal_btn').show();
                    }
                    $('#filesystem_content').html(data.content);
                    $('.card').css('cursor', 'pointer');
                    $('.card.folder').click(function () {
                        loadContent($(this).data('id'));
                    });
                    $('.card.file').click(function () {
                        window.open('{{URL::to('/')}}'+$(this).data('url'),'_blank');
                    });
                    $('.download-file-button').click(function(e){
                        e.stopPropagation();
                        let id = $(this).parent().parent().parent().data('id');
                        window.open('{{URL::to('pdi/subject/file/download')}}/'+id,'_blank');
                    });
                    $('#folder-title').html(data.currentName);

                    $('.edit-folder-button').click(function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        let form = $('#folder_'+$(this).data('id')+'_form');
                        form.find('input[type=text]')
                            .prop('disabled','')
                            .click(function(e){e.stopPropagation()})
                            .removeClass('form-control-plaintext');
                        $(this).parent().find('.save-folder-button').show();
                        $(this).hide();
                    });
                    $('.save-folder-button').click(function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        let btn = $(this);
                        let form = $('#folder_'+$(this).data('id')+'_form');
                        $.post('{{route('save_folder')}}',form.serialize(),function(response){
                            if(response === 'true'){
                                success('@lang('global.success')','@lang('filesystem.folder.save.success')');
                                form.find('input[type=text]')
                                    .prop('disabled','disabled')
                                    .addClass('form-control-plaintext');
                                btn.parent().find('.edit-folder-button').show();
                                btn.hide();
                            }else{
                                error('@lang('global.error')','@lang('filesystem.folder.save.error')');
                            }
                        });
                    });
                    $('.remove-folder-button').click(function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        let btn = $(this);
                        $.post('{{route('delete_folder')}}',{id: btn.data('id')},function(response){
                            if(response === 'true'){
                                success('@lang('global.success')','@lang('filesystem.folder.delete.success')');
                                btn.parent().parent().parent().remove();
                            }else{
                                error('@lang('global.error')','@lang('filesystem.folder.delete.error')');
                            }
                        });
                    });
                    $('.remove-file-button').click(function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        let btn = $(this);
                        $.post('{{route('delete_file')}}',{id: btn.data('id')},function(response){
                            if(response === 'true'){
                                success('@lang('global.success')','@lang('filesystem.folder.delete.success')');
                                btn.parent().parent().parent().remove();
                            }else{
                                error('@lang('global.error')','@lang('filesystem.folder.delete.error')');
                            }
                        });
                    });


                    $('#loader').hide();
                },
                error:function(){
                    $('#loader').hide();
                }
            });
        }

        $(function(){
            $('#new_file_url').dropify({
                messages: {
                    'default': '@lang('global.dropify.default')', //'Drag and drop a file here or click',
                    'replace': '@lang('global.dropify.replace')',//'Drag and drop or click to replace',
                    'remove':  '@lang('global.dropify.remove')',//'Remove',
                    'error':   '@lang('global.dropify.error')'//'Ooops, something wrong happended.'
                }
            });

            loadContent(null);

            $('#back_button').click(function(){
                loadContent($(this).data('id'));
            });

           $('#new_folder_submit').click(function(){
               $.post('{{route('new_folder')}}',{subject_id:'{{$subject->getId()}}',parent_id:$('#nav-filesystem').data('id-current'), name: $('#new_folder_name').val(), description: $('#new_folder_description').val()},
                   function(data) {
                   if(data === 'true'){
                       $('#newFolderModal').modal('hide');
                       $('#new_folder_name').val('');
                       $('#new_folder_description').val('');
                       success('@lang('global.success')','@lang('filesystem.folder.new.success')');
                       loadContent($('#nav-filesystem').data('id-current'));
                   }
               });
           });

            $('#new_file_submit').click(function(){
                if(!$('#new_file_form').valid()){
                    $('#new_file_form .dropify-wrapper').css('border', '1px solid #dc3545');
                    return false;
                }
                $('#new_file_form .dropify-wrapper').css('border', '2px solid #E5E5E5');
                let data = new FormData(document.getElementById('new_file_form'));
                data.append('folder_id',$('#nav-filesystem').data('id-current'));
                $.ajax({
                    type: 'POST',
                    url: '{{route('new_file')}}',
                    data: data,
                    mimeType: "multipart/form-data",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data === 'true') {
                            $('#newFileModal').modal('hide');
                            $('#new_file_name').val('');
                            $('#new_file_url').val('');
                            success('@lang('global.success')', '@lang('filesystem.folder.new.success')');
                            loadContent($('#nav-filesystem').data('id-current'));
                        }
                    }
                    });
            });

            $('#new_file_form').validate({
                rules:{
                    name:'required',
                    url:'required'
                },
                messages:{
                    name: "{{__('validation.required',['attribute'=>__('attributes.name')])}}",
                    url: "{{__('validation.required',['attribute'=>__('attributes.file')])}}",
                }
            });
        });
    </script>

@endsection