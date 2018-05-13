@extends('layouts.default')

@section('styles')

@endsection

@section('content')
    <div class="card text-center">
        <div class="card-header">
            @lang('pas.administration-services')
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-primary print-inscriptions">@lang('pas.print-inscriptions')</a>
            <a id="download_link" href="#" download="inscriptions" style="visibility:hidden"></a>
        </div>
    </div>
@endsection

@section('scripts')
<script>

    $(function(){
       $('.print-inscriptions').click(function(){
           iziToast.question({
               timeout: false,
               zindex: 999,
               title: '@lang('pas.inscriptions-list.toast.title')',
               message: '',
               position: 'center',
               color: '#17a2b8',
               titleColor: 'white',
               iconColor: 'white',
               inputs:[
                   ['<select class="selectpicker" multiple data-style="btn-light" data-width="auto">  @foreach(\App\Degree::all() as $degree) <option value="{{$degree->getId()}}">{{$degree->getName()}}</option> @endforeach  </select>',true]
               ],
               buttons: [
                   ['<button style="color:white">@lang('global.go')</button>', function(instance,toast){
                       document.getElementById('download_link').click();
                       return true;
                   }],
               ],
               onOpened: function(){
                   $('.selectpicker').selectpicker('render');
                   $('.selectpicker').on('changed.bs.select',function(e){
                       $('#download_link').attr('href','{{URL::to('administration/inscription-list')}}?degree_ids='+$('.selectpicker').selectpicker('val'));
                   });
               }
           });
       });
    });

</script>
@endsection