@extends('layouts.default')

@section('content')

    <form id="new-inscription" action="{{URL::to('inscription/save')}}" method="post" novalidate>
    <div id="smartwizard">
        <ul>
            <li><a href="#step-1">Datos Personales<br /><small>Rellene sus datos personales</small></a></li>
            <li><a href="#step-2">Elección de grados<br /><small>Elija hasta 5 grados</small></a></li>
            <li><a href="#step-3">Verificación<br /><small>Verifique sus datos</small></a></li>
        </ul>

        <div>
            {{csrf_field()}}
            <div id="step-1" class="p-2">
                @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>'Name'])
                @include('global.input',['type'=>'text','id'=>'surname','name'=>'surname','label'=>'Surnames'])
                @include('global.input',['type'=>'text','id'=>'nif','name'=>'nif','label'=>'N.I.F'])
                @include('global.input',['type'=>'text','id'=>'address','name'=>'address','label'=>'Address'])
                @include('global.input',['type'=>'text','id'=>'email','name'=>'email','label'=>'Email'])
                @include('global.input',['type'=>'number','id'=>'grade','name'=>'grade','label'=>'Grade','min'=>'0','max'=>'14','step'=>'0.01'])
            </div>
            <div id="step-2" class="p-2">
                @include('global.select',['id'=>'option1','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 1','default'=>'-Elija un grado-'])
                @include('global.select',['id'=>'option2','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 2','default'=>'-Elija un grado-','disabled'=>true])
                @include('global.select',['id'=>'option3','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 3','default'=>'-Elija un grado-','disabled'=>true])
                @include('global.select',['id'=>'option4','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 4','default'=>'-Elija un grado-','disabled'=>true])
                @include('global.select',['id'=>'option5','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 5','default'=>'-Elija un grado-','disabled'=>true])
            </div>
            <div id="step-3" class="">
                Step Content
            </div>
        </div>
    </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
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
            });
            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               return true;//$('#new-inscription').valid();
            });
            $('.selectpicker').change(function () {
                var prev_ids= [];
                //Recogemos los valores de los selectpickers anteriores para enviarlos por ajax
                $(this).parent().parent().prevAll().find('.selectpicker').each(function(index,element){
                    var val = $(element).selectpicker('val');
                    if(val !== "") prev_ids.push(val);
                });
                //Añadimos el valor de este al array anterior
                var this_value = $(this).selectpicker('val');
                prev_ids.push(this_value);
               //Si se ha seleccionado un valor habilitamos el siguiente selectpicker y cargamos por ajax sus options
                if(this_value !== '') {
                    var nextSelectpicker = $(this).parent().parent().next().find('.selectpicker');
                    $.get('{{URL::to('degree/all-but-selected')}}',{ids:prev_ids},function(data){
                        $(nextSelectpicker).html("");
                        $(nextSelectpicker).append('<option value="">-Elija un grado-</option>');
                        $.each(data,function(key,value){
                            $(nextSelectpicker).append('<option value="'+value['id']+'">'+value['name']+'</option>');
                            $(nextSelectpicker).prop('disabled', '');
                            $(nextSelectpicker).selectpicker('refresh');
                        });
                    });
                }else{
                    //Si el selectpicker que ha cambiado se ha seteado a vacío, deshabilitamos los posteriores y reseteamos sus valores
                    $(this).parent().parent().nextAll().find('.selectpicker').each(function (index,element) {
                        $(element).selectpicker('val','');
                        $(element).prop('disabled', true);
                        $(element).selectpicker('refresh');
                    });
                }

            });
        });


        $('#new-inscription').validate({
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

                email:{
                    required: function(){
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
                }
            },
            messages:{
                name: "{{__('validation.required',['attribute'=>'name'])}}",
                surname: "{{__('validation.required',['attribute'=>'surname'])}}",
                nif: "{{__('validation.required',['attribute'=>'nif'])}}",
                address: "{{__('validation.required',['attribute'=>'address'])}}",
                email: "{{__('validation.required',['attribute'=>'email'])}}",
                grade: "{{__('validation.required',['attribute'=>'grade'])}}",
                option1: "{{__('validation.required',['attribute'=>'option1'])}}",
            }
        })
    </script>
@endsection