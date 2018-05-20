<div id="toolbar" class="w-100 d-flex justify-content-between">
    <div class="toolbar-left">
    <button type="button" id="back_button" class="btn btn-outline-primary" data-id=""><i class="fas fa-chevron-left"></i> @lang('global.back')</button>
    </div>
    <div class="toolbar-center">
        <h3 id="folder-title"></h3>
    </div>
    <div class="toolbar-right">
        <button id="btnDropAdd" type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus"></i> @lang('filesystem.add')
        </button>
        <div class="dropdown-menu" aria-labelledby="btnDropAdd">
            <a class="dropdown-item" data-toggle="modal" data-target="#newFolderModal">@lang('filesystem.folder')</a>
            <a id="new_file_modal_btn" class="dropdown-item" data-toggle="modal" data-target="#newFileModal">@lang('filesystem.file')</a>
        </div>
    </div>
</div>
<hr>
<div id="filesystem_content">

</div>
<div class="d-flex justify-content-center w-100"><img id="loader" style="display:none" src="{{asset('loader.gif')}}"></div>

<div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('fileystem.folder.new')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new_folder_form">
                    @include('global.input',['id'=>'new_folder_name','name'=>'name','type'=>'text','label'=>__('attributes.name')])
                    @include('global.input',['id'=>'new_folder_description','name'=>'description','type'=>'text','label'=>__('attributes.description')])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.cancel')</button>
                <button type="button" class="btn btn-primary" id="new_folder_submit">@lang('global.submit')</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newFileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('fileystem.file.new')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new_file_form">
                    @include('global.input',['id'=>'new_file_name','name'=>'name','type'=>'text','label'=>__('attributes.name')])
                    <div class="form-group has-feedback">
                        <input type="file" class="dropify form-control" data-height="300" name="url" id="new_file_url"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.cancel')</button>
                <button type="button" class="btn btn-primary" id="new_file_submit">@lang('global.submit')</button>
            </div>
        </div>
    </div>
</div>