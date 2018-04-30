<div class="form-group">
    @if(isset($label)) <label class="control-label">{{$label}}</label> @endif
    <select class="selectpicker form-control @if(isset($class)) {{$class}} @endif" id="{{$id}}" name="@if(isset($name)) {{$name}} @else {{$id}} @endif" data-live-search="true" @if(isset($disabled) && $disabled) disabled @endif>
        @if(isset($default)) <option value="">{{$default}}</option> @endif
        @foreach($objects as $object)
            <option value="{{$object[$value]}}">{{$object[$display]}}</option>
        @endforeach
    </select>
    <span id="{{$id}}-error" class="help-block has-error">@if(isset($name)) {{ $errors->first($name) }} @else {{ $errors->first($id) }} @endif</span>
</div>