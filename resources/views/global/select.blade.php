@if(!isset($name))@php($name=$id)@endif
<div class="form-group @if(!empty($errors->first($name))) is-invalid @endif">
    @if(isset($label)) <label class="control-label">{{$label}}</label> @endif
    <select class="selectpicker form-control @if(isset($class)) {{$class}} @endif @if(!empty($errors->first($name))) is-invalid @endif" @if(isset($vue)) v-model="{{$name}}" @endif  id="{{$id}}" name="{{$name}}" data-live-search="true" @if(isset($disabled) && $disabled) disabled @endif>
        @if(isset($default)) <option value="">{{$default}}</option> @endif
        @foreach($objects as $object)
            <option value="{{$object[$value]}}"
                    @if(isset($vue) && isset($bind)) :value="{bind: '{{$object[$bind]}}' }" @elseif(isset($vue)) :value="{bind: '{{$object[$display]}}' }" @endif
                    @if(!is_null(old($name)) && old($name) == $object[$value]) selected="true" @endif
                    >{{$object[$display]}}</option>
        @endforeach
    </select>
    <span id="{{$id}}-error" class="help-block invalid-feedback">@if(isset($name)) {{ $errors->first($name) }} @else {{ $errors->first($id) }} @endif</span>
</div>