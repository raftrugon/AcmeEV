<div class="p-2 d-flex justify-content-end">
    @role('pdi')
    <button class="btn btn-success" id="newAnnouncementButton" data-toggle="modal" data-target="#newAnnouncementModal">
        @lang('announcement.new')
    </button>
    @endrole
</div>

<div class="card-deck row">
    @foreach($announcements as $announcement)
        <div class="col-md-12 col-xl-6" style="padding-bottom: 40px;">
            <div class="card">
                <h5 class="card-header">
                    <div class="row">
                        <div class="col-6">{{$announcement->getTitle()}}</div>
                        <div class="col-6" align="right">{{$announcement->getCreationMoment()}}</div>
                    </div>
                </h5>
                <div class="card-body col-6">
                    <p class="card-text">
                        {{$announcement->getbody()  }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>


<div class="modal fade" id="newAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('announcement.new')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="announcement_form" action="{{URL::to('pdi/announcement/save')}}" method="post"
                      novalidate>
                    {{ csrf_field() }}
                    <div class="row align-items-end">
                        @include('global.input',['col'=>'12','type'=>'text','id'=>'title','name'=>'title','label'=>__('attributes.title'),'placeholder'=>__('placeholder.text'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getTitle() : null ])
                        @include('global.input',['col'=>'12','type'=>'text','id'=>'body','name'=>'body','label'=>__('attributes.body'),'placeholder'=>__('placeholder.text'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getBody() : null ])
                        <input type="hidden" name="subject_instance_id" id="subject_instance_id" value="{{$subject->getSubjectInstances()->where('academic_year',\Carbon\Carbon::now())->first()->getId()}}">
                    </div>

                    <div class="card-footer border-info p-0">
                        <button type="submit" class="btn btn-success btn-block rounded-0" id="announcementSubmit">@lang('global.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>