@if(!isset($name))@php($name=$id)@endif
<div class="form-group">
    @if(isset($label)) <label class="control-label">{{$label}}</label> @endif
    <select class="selectpicker form-control @if(isset($class)) {{$class}} @endif" @if(isset($vue)) v-model="{{$name}}" @endif  id="{{$id}}" name="{{$name}}" data-live-search="true" @if(isset($disabled) && $disabled) disabled @endif>
        @if(isset($default)) <option value="">{{$default}}</option> @endif
        @foreach($objects as $object)
            <option value="{{$object[$value]}}" @if(isset($vue) && isset($bind)) :value="{bind: '{{$object[$bind]}}' }" @elseif(isset($vue)) :value="{bind: '{{$object[$display]}}' }" @endif>{{$object[$display]}}</option>
        @endforeach
    </select>
    <span id="{{$id}}-error" class="help-block has-error">@if(isset($name)) {{ $errors->first($name) }} @else {{ $errors->first($id) }} @endif</span>
</div>