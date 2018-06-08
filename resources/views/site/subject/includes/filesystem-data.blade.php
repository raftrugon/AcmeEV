@foreach($folders as $folder)
    <div class="card folder w-100 my-1 btn-outline-primary" data-id="{{$folder->getId()}}">
        <div class="card-body d-flex justify-content-between">
            <form id="folder_{{$folder->getId()}}_form">
            <div class="card-title mb-0 form-row align-items-center">
                <input type="hidden" name="id" value="{{$folder->getId()}}"/>
                <div class="col-auto">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="btn btn-link">
                            <i class="far fa-2x fa-folder-open"></i>
                        </div>
                    </div>
                    <input type="text" name="name" class="form-control form-control-plaintext" value="{{$folder->getName()}}" disabled="disabled"/>
                </div>
                </div>
                <div class="col-auto">
                    <input type="text" name="description" class="form-control form-control-plaintext" value="{{$folder->getDescription()}}" disabled="disabled"/>
                </div>
            </div>
            </form>
            <div class="d-flex align-items-center justify-content-start">
                @role('pdi')
                <a href="#" class="ml-1 btn btn-outline-warning edit-folder-button" data-id="{{$folder->getId()}}"> <i class="fas fa-pencil-alt"></i></a>
                <a href="#" class="ml-1 btn btn-outline-success save-folder-button" data-id="{{$folder->getId()}}" style="display:none"> <i class="far fa-save"></i></a>
                <a href="#" class="ml-1 btn btn-outline-danger @if($folder->getSubFolders->isEmpty() && $folder->getFiles->isEmpty()) remove-folder-button @else disabled @endif" data-id="{{$folder->getId()}}"> <i class="fas fa-trash"></i></a>
                @endrole
                <a href="javascript:void(0)" class="ml-1 btn btn-link btn-sm"> <i class="fas fa-eye text-light"></i></a>
            </div>
        </div>
    </div>
@endforeach

@foreach($files as $file)
    <div class="card file w-100 my-1 btn-outline-info" data-id="{{$file->getId()}}" data-url="{{$file->getUrl()}}">
        <div class="card-body d-flex justify-content-between">
            <h5 class="card-title mb-0"> <i class="fas fa-paperclip"></i> {{$file->getName()}} <a href="#" class="btn btn-outline-light download-file-button"><i class="fas fa-download"></i></a></h5>
            @role('pdi')
                <div>
                    <a href="#" class="btn btn-outline-danger remove-file-button" data-id="{{$file->getId()}}"> <i class="fas fa-trash"></i></a>
                    <a href="javascript:void(0)" class="btn btn-link btn-sm"> <i class="fas fa-eye text-light"></i></a>
                </div>
            @endrole
        </div>
    </div>
@endforeach

