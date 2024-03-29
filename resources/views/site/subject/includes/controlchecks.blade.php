@can('teach')
        <div class="">
            <a href="{{URL::to('pdi/control_check/'.$subject->getSubjectInstances()->where('academic_year',\Carbon\Carbon::now()->year)->first()->getId().'/edit')}}" class="btn btn-success float-right mb-2" id="newControlCheckButton">
                @lang('controlCheck.new')
            </a>
        </div>
    @foreach($controlChecks as $cc)
        <div class="card controlCheck w-100 my-1" data-id="{{$cc->getId()}}">
                <div class="card-body d-flex justify-content-between">
                    <div class="card-title">
                        <h3>{{$cc->getName()}} <small>{{$cc->getDescription()}}</small></h3>
                    </div>
                    <div class="d-flex align-items-center justify-content-start">
                        <a href="#" id="uploadGradesButton{{$cc->getId()}}" class="ml-1 btn btn-outline-success upload-control-check-button" title="@lang('controlCheck.csvExplanation')" data-toggle="modal" data-tooltip="tooltip" data-target="#uploadControlCheckQualifications" data-id="{{$cc->getId()}}"> <i class="fas fa-upload"></i></a>
                        <a href="{{URL::to('pdi/control_check/'.$cc->getId().'/correct')}}" class="ml-1 btn btn-outline-success upload-control-check-button" data-tooltip="tooltip" title="@lang('controlCheck.marks')" data-id="{{$cc->getId()}}"> <i class="far fa-bookmark"></i></a>
                        @if(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$cc->getDate())->gt(\Carbon\Carbon::now()))
                            <a href="{{URL::to('pdi/control_check/'.$cc->getSubjectInstance->getId().'/edit/'.$cc->getId())}}" class="ml-1 btn btn-outline-warning upload-control-check-button" title="@lang('global.edit')" data-tooltip="tooltip" data-id="{{$cc->getId()}}"> <i class="fas fa-edit"></i></a>
                            <a href="#" id="deleteControlCheck{{$cc->getId()}}" class="ml-1 btn btn-outline-danger upload-control-check-button" title="@lang('controlCheck.delete')" data-toggle="modal" data-tooltip="tooltip" data-target="#deleteControlCheck" data-id="{{$cc->getId()}}"> <i class="fas fa-trash-alt"></i></a>
                        @endif
                    </div>
                </div>
        </div>
    @endforeach
@else
    @foreach($controlCheckInstances as $cci)
        @if($cci->getControlCheck->getIsSubmittable() and $cci->getURL()===null)
          <div class="card controlCheck w-100 my-1 btn-outline-warning" data-id="{{$cci->getId()}}">
        @else
          <div class="card controlCheck w-100 my-1 btn-outline-primary" data-id="{{$cci->getId()}}">
        @endif
              <div class="card-body d-flex justify-content-between">
                  <div class="card-title">
                      <h3>{{$cci->getControlCheck->getName()}} <small>{{$cci->getControlCheck->getDescription()}}</small></h3>
                  </div>
                  <div class="card-body p-0 text-center">
                      <p>
                          @lang('controlCheck.qualification'): @if($cci->getQualification()==null)<strong> -</strong>@else {{$cci->getQualification()}}@endif
                      </p>
                  </div>
                  @if($cci->getControlCheck->getIsSubmittable() and $cci->getURL()===null)
                      <div class="d-flex align-items-center justify-content-start">
                          <a href="#" id="uploadButton{{$cci->getId()}}" class="ml-1 btn btn-outline-success upload-control-check-button" data-toggle="modal" data-target="#uploadControlCheckModal" data-id="{{$cci->getId()}}"> <i class="fas fa-upload"></i></a>
                      </div>
                  @endif
              </div>
        </div>
    @endforeach
@endcan


  <div class="modal fade" id="uploadControlCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">@lang('controlCheck.upload')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="control_check_form">
                      <input type="hidden" name="id"/>
                      <div class="form-group has-feedback">
                          <input type="file" class="dropify form-control" data-height="300" name="url" id="controlCheck_new_file"/>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.cancel')</button>
                  <button type="button" class="btn btn-primary" id="control_check_submit">@lang('global.submit')</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="uploadControlCheckQualifications" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">@lang('controlCheck.marks')</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="control_check_grades_form">
                      <input type="hidden" name="id"/>
                      <div class="form-group has-feedback">
                          <input type="file" class="dropify form-control" data-height="300" name="url" id="controlCheck_csv_qualifications"/>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.cancel')</button>
                  <button type="button" class="btn btn-primary" id="control_check_grades_submit">@lang('global.submit')</button>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="deleteControlCheck" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">

              <div class="modal-body">
                  <form id="control_check_delete">
                      <input type="hidden" name="id"/>
                      <p><strong>@lang('controlCheck.deleteConfirm')</strong></p>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.cancel')</button>
                  <button type="button" class="btn btn-primary" id="control_check_delete_button">@lang('global.confirm')</button>
              </div>
          </div>
      </div>
  </div>