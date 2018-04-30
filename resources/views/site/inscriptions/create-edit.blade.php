@extends('layouts.default')

@section('content')
    <div id="smartwizard">
        <ul>
            <li><a href="#step-1">Datos Personales<br /><small>Rellene sus datos personales</small></a></li>
            <li><a href="#step-2">Elección de grados<br /><small>Elija hasta 5 grados</small></a></li>
            <li><a href="#step-3">Verificación<br /><small>Verifique sus datos</small></a></li>
        </ul>

        <div>
            <div id="step-1" class="p-2">
                @include('global.input',['type'=>'text','id'=>'name','name'=>'name','label'=>'Name'])
                @include('global.input',['type'=>'text','id'=>'surname','name'=>'surname','label'=>'Surnames'])
                @include('global.input',['type'=>'text','id'=>'nif','name'=>'nif','label'=>'N.I.F'])
                @include('global.input',['type'=>'text','id'=>'address','name'=>'address','label'=>'Address'])
                @include('global.input',['type'=>'text','id'=>'email','name'=>'email','label'=>'Email'])
                @include('global.input',['type'=>'number','id'=>'grade','name'=>'grade','label'=>'Grade','min'=>'0','max'=>'14','step'=>'0.01'])
            </div>
            <div id="step-2" class="p-2">
                @include('global.select',['id'=>'1','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 1','default'=>'-Elija un grado-'])
                @include('global.select',['id'=>'2','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 2','default'=>'-Elija un grado-'])
                @include('global.select',['id'=>'3','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 3','default'=>'-Elija un grado-'])
                @include('global.select',['id'=>'4','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 4','default'=>'-Elija un grado-'])
                @include('global.select',['id'=>'5','objects'=>$degrees,'value'=>'id','display'=>'name','label'=>'Option 5','default'=>'-Elija un grado-'])
            </div>
            <div id="step-3" class="">
                Step Content
            </div>
        </div>
    </div>
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
                toolbarSettings:{
                    toolbarPosition:'none'
                }
            });
        });
    </script>
@endsection