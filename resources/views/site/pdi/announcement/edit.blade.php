 <div class="row justify-content-center">
        <div class="col-md-10">

            <form id="announcement_form" action="{{URL::to('pdi/announcement/save')}}" method="post"
                  novalidate>
                {{ csrf_field() }}
                <div class="row align-items-end">
                    @include('global.input',['col'=>'12','type'=>'text','id'=>'title','name'=>'title','label'=>__('attributes.title'),'placeholder'=>__('placeholder.text'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getTitle() : null ])
                    @include('global.input',['col'=>'12','type'=>'text','id'=>'body','name'=>'body','label'=>__('attributes.body'),'placeholder'=>__('placeholder.text'), 'required'=>true, 'value'=>isset($announcement) ? $announcement->getBody() : null ])
                    <input type="hidden" name="subject_instance_id" id="subject_instance_id" value="{{$subject_instance_id}}">
                </div>

                <div class="card-footer border-info p-0">
                    <button type="submit" class="btn btn-success btn-block rounded-0" id="announcementSubmit">@lang('global.submit')</button>
                </div>
            </form>
        </div>
    </div>
