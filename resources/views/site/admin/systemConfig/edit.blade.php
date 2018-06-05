@extends('layouts.default')

@section('content')



    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-info">
                <div class="card-header text-center border-info">
                    <ul class="nav nav-pills card-header-pills nav-fill">
                        <li class="nav-item col-md-4" style="padding: 0; margin: 0">
                            <a class="nav-link active" data-toggle="pill" href="#tab1" role="button"
                               aria-expanded="true"
                               aria-controls="tab1"><Strong>@lang('systemConfig.edit.tab2')</Strong></a>
                        </li>
                        <li class="nav-item col-md-4" style="padding: 0; margin: 0">
                            <a class="nav-link" data-toggle="pill" href="#tab2" role="button" aria-expanded="false"
                               aria-controls="tab2"><Strong>@lang('systemConfig.edit.tab1')</Strong></a>
                        </li>
                        <li class="nav-item col-md-4" style="padding: 0; margin: 0">
                            <a class="nav-link" data-toggle="pill" href="#tab3" role="button" aria-expanded="false"
                               aria-controls="tab3"><Strong>@lang('systemConfig.edit.dashboard')</Strong></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">

                    {{---------------------------------------------------------------------------------------------------- FIRST TAB ----------------------------------------------------------------------------------------------------}}
                    <div class="tab-pane fade show active" id="tab1" data-parent="#accordion">
                        <div class="row" style="padding: 0; margin: 0;">
                            <div class="row col-12" style="padding: 0; margin: 0;">
                                <div class="card border-success col-5 mb-3" style="max-width: 95%;padding:0;margin: 0">
                                    <div class="card-header text-center font-weight-bold">@lang('systemConfig.state.actual')</div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title">@lang($state_actual_title)</h5>
                                        <p class="card-text">@lang($state_actual_body)</p>
                                    </div>
                                </div>
                                <div class="col-2" style="max-width: 95%;padding: 30px 0;margin: 0">
                                    <a class="text-light nav-link" href="{{URL::to('admin/systemconfig/increment-state')}}">
                                        <i class="fas fa-arrow-alt-circle-right d-block text-primary text-center" style="font-size: 60px; margin-top: 50px"></i>
                                        <span class="d-block text-primary text-center text-" style="font-size: 16px; margin-top: 5px">
                                            <strong>@lang('systemConfig.state.go')</strong>
                                        </span>
                                    </a>
                                </div>
                                <div class="card border-primary col-5 mb-3" style="max-width: 95%;padding:0;margin: 0">
                                    <div class="card-header text-center font-weight-bold">@lang('systemConfig.state.next')</div>
                                    <div class="card-body text-info">
                                        <h5 class="card-title">@lang($state_next_title)</h5>
                                        <p class="card-text">@lang($state_next_body)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{---------------------------------------------------------------------------------------------------- SECOND TAB ----------------------------------------------------------------------------------------------------}}
                    <div class="tab-pane fade" id="tab2" data-parent="#accordion">
                        <form id="systemconfig_form" action="{{URL::to('admin/systemconfig/save')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row align-items-end">
                                @include('global.input',['col'=>'6','class'=>'time','type'=>'text','id'=>'building_open_time','name'=>'building_open_time','label'=>__('attributes.building_open_time'),'placeholder'=>__('placeholder.time'),  'value'=>isset($system_config) ? $system_config->getBuildingOpenTime() : null ])
                                @include('global.input',['col'=>'6','class'=>'time','type'=>'text','id'=>'building_close_time','name'=>'building_close_time','label'=>__('attributes.building_close_time'),'placeholder'=>__('placeholder.time'),  'value'=>isset($system_config) ? $system_config->getBuildingCloseTime() : null ])
                            </div>
                            <div class="row align-items-end">
                                @include('global.input',['col'=>'6','type'=>'number','id'=>'max_students_per_group','name'=>'max_students_per_group','label'=>__('attributes.max_students_per_group'),'placeholder'=>__('placeholder.number'),  'value'=>isset($system_config) ? $system_config->getMaxStudentsPerGroup() : null ])
                            </div>
                            <div class="row align-items-start">
                                <div class="col-7 pl-0">
                                @include('global.input',['col'=>'12','type'=>'text','id'=>'name_en','label'=>__('attributes.name_en'),'placeholder'=>__('placeholder.name_en'),  'value'=>isset($system_config) ? $system_config->getNameEn() : null ])
                                @include('global.input',['col'=>'12','type'=>'text','id'=>'name_es','label'=>__('attributes.name_es'),'placeholder'=>__('placeholder.name_es'),  'value'=>isset($system_config) ? $system_config->getNameEs() : null ])
                                </div>
                                <div class="col-5 py-3">
                                    <input type="file" id="icon_input" name="icon" @if(isset($system_config) && !is_null($system_config->getIcon())) data-default-file="{{URL::to($system_config->getIcon())}}" @endif>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col w-100">
                                <input type="file" id="banner_input" name="banner" @if(isset($system_config) && !is_null($system_config->getBanner())) data-default-file="{{URL::to($system_config->getBanner())}}" @endif>
                                </div>
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

                    {{---------------------------------------------------------------------------------------------------- THIRD TAB ----------------------------------------------------------------------------------------------------}}
                    <div class="tab-pane fade" id="tab3" data-parent="#accordion">
                       @include('site.admin.systemConfig.dashboard')
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Dashboard -->
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script>
        $(function () {
            $('.time').datetimepicker({
                format: 'HH:mm:ss'
            });
            $('#icon_input').dropify();
            $('#banner_input').dropify();
            $('#systemconfig_form').submit(function(){
                if(!$('#systemconfig_form').valid()) return false;
            });
            $('#systemconfig_form').validate({
                rules: {
                    building_open_time: 'required',
                    building_close_time: 'required',
                    name_en: 'required',
                    name_es: 'required',
                },
                messages: {
                    building_open_time: "{{__('validation.required',['attribute'=>__('building_open_time')])}}",
                    building_close_time: "{{__('validation.required',['attribute'=>__('building_close_time')])}}",
                    name_en: "{{__('validation.required',['attribute'=>__('name_en')])}}",
                    name_es: "{{__('validation.required',['attribute'=>__('name_es')])}}",
                }
            });
        });
    </script>
    {{------------------ Dashboard Charts --------------------}}
    <script>
        $(function() {
            let inscription_data = {
                datasets: [{
                    data: {{$inscription_donut_data}},
                    backgroundColor: ['#28a745','#dc3545'],
                }],

                labels: [
                    '@lang('global.yes')',
                    '@lang('global.no')'
                ],

            };

            let inscriptionDonut = new Chart(document.getElementById('inscriptions_donut'), {
                type: 'doughnut',
                data: inscription_data,
                options: {
                    title: {
                        display: true,
                        text: '@lang('dashboard.inscriptions_donut')'
                    }
                }

            });

            let enrollment_data = {
                datasets:[{
                    data: {!!$enrollment_tries_per_school_year['1'] !!},
                    backgroundColor: 'rgba(61,9,145,0.5)',
                    label: '@lang('enrollment.year_1')',
                    showLine: true,
                },{
                    data: {!!$enrollment_tries_per_school_year['2'] !!},
                    backgroundColor: 'rgba(145,61,9,0.5)',
                    label: '@lang('enrollment.year_2')',
                    showLine: true,
                },{
                    data: {!!$enrollment_tries_per_school_year['3'] !!},
                    backgroundColor: 'rgba(9,145,61,0.5)',
                    label: '@lang('enrollment.year_3')',
                    showLine: true,
                },{
                    data: {!!$enrollment_tries_per_school_year['4'] !!},
                    backgroundColor: 'rgba(145,9,93,0.5)',
                    label: '@lang('enrollment.year_4')',
                    showLine: true,
                },

                ],

            };

            let enrollmentBubble = new Chart(document.getElementById('enrollment_tries'), {
                type: 'scatter',
                data: enrollment_data,
                options: {
                    tooltips: {
                        callbacks: {
                            afterLabel: function(tooltipItem, data) {
                                data = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return '@lang('global.try'): '+data['x'];
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: '@lang('dashboard.enrollments_bubble')'
                    },

                }

            });

            let appointments_data = {
                datasets: [{
                    data: {!!$appointments_per_hour!!},
                    backgroundColor: '#fd7e14',
                    borderColor: '#fd7e14',
                    label: '@lang('dashboard.appointments_per_hour')'
                }],
            };
            let appointmentsLine = new Chart(document.getElementById('appointments_per_hour'), {
                type: 'scatter',
                data: appointments_data,
                options: {
                    title: {
                        display: true,
                        text: '@lang('dashboard.appointments_line')'
                    },
                    scales: {
                        xAxes: [{
                            type: 'time',
                            position: 'bottom',
                            time:{
                                unit: 'minute',
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                type: 'linear',
                                min: 0,
                            }
                        }]
                    }
                }

            });
        });
    </script>
@endsection