<form class="p-3" id="create_edit_form">
    @if(isset($user))
        <input type="hidden" name="id" value="{{$user->getId()}}"/>
    @endif
    <div class="row">
        @include('global.input',['type'=>'text','id'=>'name','label'=>__('attributes.name'),'col'=>'6','value'=>isset($user) ? $user->getName() : null])
        @include('global.input',['type'=>'text','id'=>'surname','label'=>__('attributes.surname'),'col'=>'6','value'=>isset($user) ? $user->getSurname() : null])
    </div>
    <div class="row">
        @include('global.input',['type'=>'text','id'=>'email','label'=>__('attributes.email'),'col'=>'6','value'=>isset($user) ? $user->getEmail() : null])
        @include('global.input',['type'=>'text','id'=>'personal_email','label'=>__('attributes.personal_email'),'col'=>'6','value'=>isset($user) ? $user->getPersonalEmail() : null])
    </div>
    <div class="row">
        @include('global.input',['type'=>'text','id'=>'address','label'=>__('attributes.address'),'col'=>'4','value'=>isset($user) ? $user->getAddress() : null])
        @include('global.input',['type'=>'text','id'=>'phone_number','label'=>__('attributes.phone_number'),'col'=>'4','value'=>isset($user) ? $user->getPhoneNumber() : null])
        @include('global.input',['type'=>'text','id'=>'id_number','label'=>__('attributes.id_number'),'col'=>'4','value'=>isset($user) ? $user->getIdNumber() : null])
    </div>
    <div class="row">
        <div class="col">
            @include('global.select',['id'=>'roles','name'=>'roles[]','label'=>__('attributes.role'),'objects'=>$roles,'value'=>'id','display'=>'name','multiselect'=>true,'selectedOption'=>isset($user) ? $user->roles->pluck('id')->toArray() : null])
        </div>
        <div class="col">
            @include('global.select',['id'=>'permissions','name'=>'permissions[]','label'=>__('attributes.permission'),'objects'=>$permissions,'value'=>'id','display'=>'name','multiselect'=>true,'selectedOption'=>isset($user) ? $user->permissions->pluck('id')->toArray() : null])
        </div>
        <div class="col department-col" style="display:none">
            @include('global.select',['id'=>'department_id','name'=>'department_id','label'=>__('attributes.department'),'objects'=>$departments,'value'=>'id','display'=>'name','selectedOption'=>isset($user) && !is_null($user->getDepartment) ? $user->getDepartment->getId() : null,'default'=>__('global.choose_one')])
        </div>
    </div>
    <div class="row">
        <div class="btn-group w-100" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary w-50" data-izimodal-close="">@lang('global.cancel')</button>
            <button type="submit" class="btn btn-success w-50">@lang('global.submit')</button>
        </div>
    </div>
</form>