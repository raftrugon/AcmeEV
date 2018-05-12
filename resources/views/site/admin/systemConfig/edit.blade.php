@extends('layouts.default')

@section('content')

    <form id="systemconfig_form" action="{{URL::to('admin/systemconfig/save')}}" method="post" novalidate>
        {{ csrf_field() }}
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-info" >
                    <div class="card-header text-center">
                        <Strong>@lang('systemConfig.edit.title')</Strong>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end">
                        @include('global.input',['col'=>'3','type'=>'number','id'=>'max_summons_number','name'=>'max_summons_number','label'=>__('attributes.max_summons_number'),'placeholder'=>__('placeholder.number'), 'value'=>isset($system_config) ? $system_config->getMaxSummonsNumber() : null ])
                        @include('global.input',['col'=>'3','type'=>'number','id'=>'max_annual_summons_number','name'=>'max_annual_summons_number','label'=>__('attributes.max_annual_summons_number'),'placeholder'=>__('placeholder.number'), 'value'=>isset($system_config) ? $system_config->getMaxAnnualSummonsNumber() : null ])
                        @include('global.input',['col'=>'3','type'=>'text','id'=>'secretariat_open_time','name'=>'secretariat_open_time','label'=>__('attributes.secretariat_open_time'),'placeholder'=>__('placeholder.time'), 'value'=>isset($system_config) ? $system_config->getSecretariatOpenTime() : null ])
                        @include('global.input',['col'=>'3','type'=>'text','id'=>'secretariat_close_time','name'=>'secretariat_close_time','label'=>__('attributes.secretariat_close_time'),'placeholder'=>__('placeholder.time'), 'value'=>isset($system_config) ? $system_config->getSecretariatCloseTime() : null ])
                        </div>
                        <div class="row align-items-end">
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'inscriptions_start_date','name'=>'inscriptions_start_date','label'=>__('attributes.inscriptions_start_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getInscriptionsStartDate() : null ])
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'first_provisional_inscr_list_date','name'=>'first_provisional_inscr_list_date','label'=>__('attributes.first_provisional_inscr_list_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getFirstProvisionalInscrListDate() : null ])
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'second_provisional_inscr_list_date','name'=>'second_provisional_inscr_list_date','label'=>__('attributes.second_provisional_inscr_list_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getSecondProvisionalInscrListDate() : null ])
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'final_inscr_list_date','name'=>'final_inscr_list_date','label'=>__('attributes.final_inscr_list_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getFinalInscrListDate() : null ])
                        </div>
                        <div class="row align-items-end">
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'enrolment_start_date','name'=>'enrolment_start_date','label'=>__('attributes.enrolment_start_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getEnrolmentStartDate() : null ])
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'enrolment_end_date','name'=>'enrolment_end_date','label'=>__('attributes.enrolment_end_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getEnrolmentEndDate() : null ])
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'provisional_minutes_date','name'=>'provisional_minutes_date','label'=>__('attributes.provisional_minutes_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getProvisionalMinutesDate() : null ])
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'final_minutes_date','name'=>'final_minutes_date','label'=>__('attributes.final_minutes_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getFinalMinutesDate() : null ])
                        </div>
                        <div class="row align-items-end">
                        @include('global.input',['col'=>'3','type'=>'date','id'=>'academic_year_end_date','name'=>'academic_year_end_date','label'=>__('attributes.academic_year_end_date'),'placeholder'=>__('placeholder.date'), 'value'=>isset($system_config) ? $system_config->getAcademicYearEndDate() : null ])
                        </div>

                        @isset($system_config)
                            <input type="hidden" name="id" id="id" value="{{$system_config->getId()}}">
                        @endisset
                        <button type="submit" class="btn btn-success btn-block">@lang('global.submit')</button>
                    </div>
                </div>
            </div>
        </div>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
/*function submitForm(){
$('#degree_form').submit();
};*/

$('#systemconfig_form').validate({
rules:{
    max_summons_number : required,
    max_annual_summons_number : required,
    secretariat_open_time : required,
    secretariat_close_time : required,
    inscriptions_start_date : required,
    first_provisional_inscr_list_date : required,
    second_provisional_inscr_list_date : required,
    final_inscr_list_date : required,
    enrolment_start_date : required,
    enrolment_end_date : required,
    provisional_minutes_date : required,
    final_minutes_date : required,
    academic_year_end_date : required

},

messages:{

    max_summons_number :  "{{__('validation.required',['attribute'=>__('max_summons_number')])}}",
    max_annual_summons_number :  "{{__('validation.required',['attribute'=>__('max_annual_summons_number')])}}",
    secretariat_open_time :  "{{__('validation.required',['attribute'=>__('secretariat_open_time')])}}",
    secretariat_close_time :  "{{__('validation.required',['attribute'=>__('secretariat_close_time')])}}",
    inscriptions_start_date :  "{{__('validation.required',['attribute'=>__('inscriptions_start_date')])}}",
    first_provisional_inscr_list_date :  "{{__('validation.required',['attribute'=>__('first_provisional_inscr_list_date')])}}",
    second_provisional_inscr_list_date :  "{{__('validation.required',['attribute'=>__('second_provisional_inscr_list_date')])}}",
    final_inscr_list_date :  "{{__('validation.required',['attribute'=>__('final_inscr_list_date')])}}",
    enrolment_start_date :  "{{__('validation.required',['attribute'=>__('enrolment_start_date')])}}",
    enrolment_end_date :  "{{__('validation.required',['attribute'=>__('enrolment_end_date')])}}",
    provisional_minutes_date :  "{{__('validation.required',['attribute'=>__('provisional_minutes_date')])}}",
    final_minutes_date :  "{{__('validation.required',['attribute'=>__('final_minutes_date')])}}",
    academic_year_end_date :  "{{__('validation.required',['attribute'=>__('academic_year_end_date')])}}"
}
});
</script>
@endsection