@extends('layouts.default')

@section('content')

    <form id="inscription_form" action="{{URL::to('inscription/save')}}" method="post" novalidate>
    <div id="smartwizard">
        <ul>
            <li><a href="#step-1">@lang('inscription.step1.title')<br /><small>@lang('inscription.step1.subtitle')</small></a></li>
            <li><a href="#step-2">@lang('inscription.step2.title')<br /><small>@lang('inscription.step2.subtitle')</small></a></li>
            <li><a href="#step-3">@lang('inscription.step3.title')<br /><small>@lang('inscription.step3.subtitle')</small></a></li>
        </ul>

        <div>
            {{csrf_field()}}
            <div id="step-1" class="p-2">
                @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>__('attributes.name'),'vue'=>true])
                @include('global.input',['type'=>'text','id'=>'surname','name'=>'surname','label'=>__('attributes.surname'),'vue'=>true])
                @include('global.input',['type'=>'text','id'=>'nif','name'=>'nif','label'=>__('attributes.nif'),'vue'=>true])
                @include('global.input',['type'=>'text','id'=>'address','name'=>'address','label'=>__('attributes.address'),'vue'=>true])
                @include('global.input',['type'=>'text','id'=>'phone_number','name'=>'phone_number','label'=>__('attributes.phone_number'),'vue'=>true])
                @include('global.input',['type'=>'text','id'=>'email','name'=>'email','label'=>__('attributes.email'),'vue'=>true])
                @include('global.input',['type'=>'number','id'=>'grade','name'=>'grade','label'=>__('attributes.grade'),'min'=>'0','max'=>'14','step'=>'0.01','vue'=>true])
            </div>
            <div id="step-2" class="p-2">
                @include('global.select',['id'=>'option1','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>__('global.option',['number'=>1]),'default'=>__('global.choose_one')])
                @include('global.select',['id'=>'option2','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>__('global.option',['number'=>2]),'default'=>__('global.choose_one'),'disabled'=>true])
                @include('global.select',['id'=>'option3','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>__('global.option',['number'=>3]),'default'=>__('global.choose_one'),'disabled'=>true])
                @include('global.select',['id'=>'option4','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>__('global.option',['number'=>4]),'default'=>__('global.choose_one'),'disabled'=>true])
                @include('global.select',['id'=>'option5','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>__('global.option',['number'=>5]),'default'=>__('global.choose_one'),'disabled'=>true])
            </div>
            <div id="step-3" class="p-2">
                <div class="card-deck">
                    <div class="card border-info bg-light">
                        <div class="card-header border-info">@lang('inscription.personal_data')</div>
                        <div class="card-body">
                            <p class="card-text"><strong>@lang('attributes.name'):</strong> @{{ name }} </p>
                            <p class="card-text"><strong>@lang('attributes.surname'):</strong> @{{ surname }} </p>
                            <p class="card-text"><strong>@lang('attributes.nif'):</strong> @{{ nif }} </p>
                            <p class="card-text"><strong>@lang('attributes.address'):</strong> @{{ address }} </p>
                            <p class="card-text"><strong>@lang('attributes.phone_number'):</strong> @{{ phone_number }} </p>
                            <p class="card-text"><strong>@lang('attributes.email'):</strong> @{{ email }} </p>
                            <p class="card-text"><strong>@lang('attributes.grade'):</strong> @{{ grade }} </p>
                        </div>
                    </div>
                    <div class="card border-info bg-light">
                        <div class="card-header border-info">@lang('inscription.choices')</div>
                        <div class="card-body">
                            <p class="card-text option1"><strong>@lang('global.option',['number'=>1]):</strong> <span> - </span></p>
                            <p class="card-text option2"><strong>@lang('global.option',['number'=>2]):</strong> <span> - </span></p>
                            <p class="card-text option3"><strong>@lang('global.option',['number'=>3]):</strong> <span> - </span></p>
                            <p class="card-text option4"><strong>@lang('global.option',['number'=>4]):</strong> <span> - </span></p>
                            <p class="card-text option5"><strong>@lang('global.option',['number'=>5]):</strong> <span> - </span></p>
                        </div>
                    </div>
                </div>
                <div class="card border-info bg-light mt-2">
                    <div class="card-header border-info">@lang('inscription.access_data')</div>
                    <div class="card-body d-inline-flex">
                        @include('global.input',['type'=>'text','id'=>'user','name'=>'nif','label'=>__('attributes.user'),'col'=>4,'readonly'=>true,'vue'=>true])
                        @include('global.input',['type'=>'password','id'=>'password','label'=>__('attributes.password'),'col'=>4])
                        @include('global.input',['type'=>'password','id'=>'password_repeat','label'=>__('attributes.password.repeat'),'col'=>4])
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {!! NoCaptcha::display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        function submitForm(){
            $('#inscription_form').submit();
        }
        $(document).ready(function(){
            $('#smartwizard').smartWizard({
                theme:'arrows',
                useURLhash:false,
                showStepURLhash:false,
                transitionEffect:'slide',
                anchorSettings: {
                    markDoneStep: true, // add done css
                    removeDoneStepOnNavigateBack: true
                },
                lang:{
                    next: '@lang('global.next')',
                    previous: '@lang('global.previous')'
                }
            });
            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               return $('#inscription_form').valid();
            });
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
                var nextButton = $('.sw-toolbar button:last-child');
                if(stepNumber === 2){
                    nextButton.removeClass('btn-secondary');
                    nextButton.addClass('btn-success');
                    nextButton.html('@lang('global.finish') <i class="fa fa-check"></i>');
                    nextButton.removeClass('disabled');
                    nextButton.click(submitForm);
                }else{
                    nextButton.addClass('btn-secondary');
                    nextButton.removeClass('btn-success');
                    nextButton.text('@lang('global.next')');
                    nextButton.off('click',submitForm);
                }
            });
            $('.selectpicker').change(function () {
                let prev_ids= [];
                //Mostramos el valor en el último step
                if($(this).selectpicker('val') === '')  $('.'+$(this).attr('id')+' span').html(' - ');
                else $('.'+$(this).attr('id')+' span').html($(this).find(':selected').text());
                //Recogemos los valores de los selectpickers anteriores para enviarlos por ajax
                $(this).parent().parent().prevAll().find('.selectpicker').each(function(index,element){
                    let val = $(element).selectpicker('val');
                    if(val !== "") prev_ids.push(val);
                });
                //Añadimos el valor de este al array anterior
                let this_value = $(this).selectpicker('val');
                prev_ids.push(this_value);
               //Si se ha seleccionado un valor habilitamos el siguiente selectpicker y cargamos por ajax sus options
                if(this_value !== '') {
                    $(this).parent().parent().nextAll().find('.selectpicker').each(function (index,element) {
                        let nextSelectpicker = element;
                        $.get('{{URL::to('degree/all-but-selected')}}',{ids:prev_ids},function(data){
                            $(nextSelectpicker).html("");
                            $(nextSelectpicker).append('<option value="">{{__('global.choose_one')}}</option>');
                            $.each(data,function(key,value){
                                $(nextSelectpicker).append('<option value="'+value['id']+'">'+value['name']+'</option>');
                            });
                            if(index === 0) $(nextSelectpicker).prop('disabled', '');
                            else $(nextSelectpicker).prop('disabled', true);
                            $(nextSelectpicker).selectpicker('refresh');
                            $('.'+$(nextSelectpicker).attr('id')+' span').html(' - ');
                        });
                    });
                }else{
                    //Si el selectpicker que ha cambiado se ha seteado a vacío, deshabilitamos los posteriores y reseteamos sus valores
                    $(this).parent().parent().nextAll().find('.selectpicker').each(function (index,element) {
                        $(element).selectpicker('val','');
                        $(element).prop('disabled', true);
                        $(element).selectpicker('refresh');
                        $('.'+$(element).attr('id')+' span').html(' - ');
                    });
                }

            });
        });


        $('#inscription_form').validate({
            rules:{
                name:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },

                surname:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },

                nif:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },

                address:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },

                phone_number:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },

                email:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    },
                    email:  function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },

                grade:{
                    required: function(){
                        return $('#smartwizard li:first-child').hasClass('active');
                    }
                },
                option1:{
                    required: function(){
                        return $('#smartwizard li:nth-child(2)').hasClass('active');
                    }
                },
                password:{
                    required: function(){
                        return $('#smartwizard li:nth-child(3)').hasClass('active');
                    }
                },
                password_repeat:{
                    required: function(){
                        return $('#smartwizard li:nth-child(3)').hasClass('active');
                    },
                    equalTo:{
                        param: '#password',
                        depends: function() {
                            return $('#smartwizard li:nth-child(3)').hasClass('active');
                        }
                    }
                }

            },
            messages:{
                name: "{{__('validation.required',['attribute'=>__('attributes.name')])}}",
                surname: "{{__('validation.required',['attribute'=>__('attributes.surname')])}}",
                nif: "{{__('validation.required',['attribute'=>__('attributes.nif')])}}",
                address: "{{__('validation.required',['attribute'=>__('attributes.address')])}}",
                phone_number: "{{__('validation.required',['attribute'=>__('attributes.phone_number')])}}",
                email:{
                    required: "{{__('validation.required',['attribute'=>__('attributes.email')])}}",
                    email: "{{__('validation.email',['attribute'=>__('attributes.email')])}}",
                },
                grade: "{{__('validation.required',['attribute'=>__('attributes.grade')])}}",
                option1: "{{__('validation.required',['attribute'=>__('global.option',['number'=>1])])}}",
                password: "{{__('validation.required',['attribute'=>__('attributes.password')])}}",
                password_repeat:{
                    required: "{{__('validation.required',['attribute'=>__('attributes.password.repeat')])}}",
                    equalTo: "{{__('validation.same',['attribute'=>__('attributes.password'),'other'=>__('attributes.password.repeat')])}}",
                }
            }
        });
        @include('global.input-v-js',['id'=>'smartwizard','inputs'=>['name','surname','nif','address','phone_number','email','grade']])
    </script>
    {!! NoCaptcha::renderJs(App::getLocale()) !!}
@endsection