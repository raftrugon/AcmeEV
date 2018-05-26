@extends('layouts.default')

@section('content')



    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-info">
                <div class="card-header text-center border-info">
                    <ul class="nav nav-pills card-header-pills nav-fill">
                        <li class="nav-item col-md-6" style="padding: 0; margin: 0">
                            <a class="nav-link active" data-toggle="pill" href="#tab1" role="button"
                               aria-expanded="true"
                               aria-controls="tab1"><Strong>@lang('systemConfig.edit.tab1')</Strong></a>
                        </li>
                        <li class="nav-item col-md-6" style="padding: 0; margin: 0">
                            <a class="nav-link" data-toggle="pill" href="#tab2" role="button" aria-expanded="false"
                               aria-controls="tab2"><Strong>@lang('systemConfig.edit.tab2')</Strong></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">

                    <div class="tab-pane fade show active" id="tab1" data-parent="#accordion">
                        <form id="systemconfig_form" action="{{URL::to('admin/systemconfig/save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row align-items-end">
                                @include('global.input',['col'=>'6','type'=>'number','id'=>'max_summons_number','name'=>'max_summons_number','label'=>__('attributes.max_summons_number'),'placeholder'=>__('placeholder.number'),  'value'=>isset($system_config) ? $system_config->getMaxSummonsNumber() : null ])
                                @include('global.input',['col'=>'6','type'=>'number','id'=>'max_annual_summons_number','name'=>'max_annual_summons_number','label'=>__('attributes.max_annual_summons_number'),'placeholder'=>__('placeholder.number'),  'value'=>isset($system_config) ? $system_config->getMaxAnnualSummonsNumber() : null ])
                            </div>
                            <div class="row align-items-end">
                                @include('global.input',['col'=>'6','class'=>'time','type'=>'text','id'=>'secretariat_open_time','name'=>'secretariat_open_time','label'=>__('attributes.secretariat_open_time'),'placeholder'=>__('placeholder.time'),  'value'=>isset($system_config) ? $system_config->getSecretariatOpenTime() : null ])
                                @include('global.input',['col'=>'6','class'=>'time','type'=>'text','id'=>'secretariat_close_time','name'=>'secretariat_close_time','label'=>__('attributes.secretariat_close_time'),'placeholder'=>__('placeholder.time'),  'value'=>isset($system_config) ? $system_config->getSecretariatCloseTime() : null ])
                            </div>

                            @isset($system_config)
                                <input type="hidden" name="id" id="id" value="{{$system_config->getId()}}">
                                <input type="hidden" name="actual_state" id="actual_state" value="{{$system_config->getActualState()}}">
                                <input type="hidden" name="inscriptions_list_status" id="inscriptions_list_status" value="{{$system_config->getInscriptionsListStatus()}}">
                            @endisset
                            <div class="card-footer border-info p-0">
                                <button type="submit"
                                        class="btn btn-success btn-block rounded-0">@lang('global.submit')</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab2" data-parent="#accordion">
                        <div class="row">
                            <button id="first_inscriptions" type="button"
                                    class="btn btn-info col-sm-4">@lang('systemConfig.edit.first-inscriptions')</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
    <script>
        $(function () {
            $('.time').datetimepicker({
                format: 'HH:mm:ss'
            });
            $('#first_inscriptions').click(function () {
                $.post('{{route('process_inscriptions')}}', function (data) {
                    if (data === 'true') {
                        success('asdf', 'asdf');
                    } else {
                        error('fdsa', 'fdsa');
                    }
                });
            });
            $('#systemconfig_form').submit(function(){
                if(!$('#systemconfig_form').valid()) return false;
            });
            $('#systemconfig_form').validate({
                rules: {
                    max_summons_number: 'required',
                    max_annual_summons_number: 'required',
                    secretariat_open_time: 'required',
                    secretariat_close_time: 'required',
                },
                messages: {
                    max_summons_number: "{{__('validation.required',['attribute'=>__('max_summons_number')])}}",
                    max_annual_summons_number: "{{__('validation.required',['attribute'=>__('max_annual_summons_number')])}}",
                    secretariat_open_time: "{{__('validation.required',['attribute'=>__('secretariat_open_time')])}}",
                    secretariat_close_time: "{{__('validation.required',['attribute'=>__('secretariat_close_time')])}}",
                }
            });
        });
    </script>
@endsection