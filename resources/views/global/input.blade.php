{{--INPUT TYPE TEXT-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-12] (Optional)                   *
*   Icon (Optional)                         *
*   Class (Optional)                        *
*   Value (Optional)                        *
*   Mask (Optional)                         *
*   Placeholder (Optional)                  *
*   Tooltip (Optional)                      *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='text')

    @if(!isset($name))@php $name = $id;@endphp @endif

    @if(isset($aling) && $aling=='horizontal')

        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif " >

            @if(isset($label))<label  class="control-label col-md-2 {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">

                <div class="input-group">

                    <input  id="{{$id}}" name="{{$name}}" type="text"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                            @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                            @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                            class=" form-control @if(isset($class)){{$class}}@endif"
                            @if(isset($required) && $required==true) required="required" @endif
                            value="{{ old($name, isset($value)?$value:null) }}"
                            @if(isset($data_attributes))
                            @foreach($data_attributes as $attr_name=>$attr_value)
                            data-{{$attr_name}}="{{$attr_value}}"
                            @endforeach
                            @endif
                    >
                    @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
                </div>
                <span id="{{$id}}-error" class="help-block invalid-feedback>{{ $errors->first($name) }} </span>
            </div>
        </div>
    @else
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'is-invalid has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif " >

                @if(isset($label))<label  class="control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif

                <div class="input-group">

                    <input  id="{{$id}}" name="{{$name}}" @if(isset($vue)) v-model="{{$name}}" @endif type="text"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                            @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                            @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                            class=" form-control @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                            @if(isset($required) && $required==true) required="required" @endif
                           value="{{ old($name, isset($value)?$value:null) }}"

                            @if(isset($data_attributes))
                                @foreach($data_attributes as $attr_name=>$attr_value)
                                    data-{{$attr_name}}="{{$attr_value}}"
                                @endforeach
                            @endif
                    >

                    @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif

                </div>

                <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>
        </div>

    @endif
@endif




{{--INPUT TYPE NUMBER-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-12] (Optional)                   *
*   Icon (Optional)                         *
*   Class (Optional)                        *
*   Value (Optional)                        *
*   Mask (Optional)                         *
*   Placeholder (Optional)                  *
*   Tooltip (Optional)                      *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='number')

    @if(!isset($name))@php $name = $id; @endphp @endif

    @if(isset($aling) && $aling=='horizontal')

        <div id="@if(isset($block_id)){{$block_id}} @endif" class="form-group @if(isset($col)) col-md-{{$col}} @endif"@if(isset($hidden)) style="display: none"@endif>
            @if(isset($label))<label  class="control-label col-md-2 {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input @if(isset($readonly) && $readonly==true)readonly="readonly" @endif @if(isset($disabled) && $disabled==true)disabled="disabled" @endif id="{{$id}}"  class=" form-control @if(isset($class)){{$class}}@endif"  @if(isset($required) && $required==true) required="required" @endif type="number" name="{{$name}}" placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif" value="{{ old($name, isset($value)?$value:null) }}" @if(isset($mask)))data-mask="{{$mask}}" @endif @if(isset($min)) min='{{$min}}' @endif @if(isset($max)) max='{{$max}}' @endif @if(isset($step)) step='{{$step}}' @endif>

                            @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
                        </div>
                    </div>
                </div>
                <span id="{{$id}}-error" class="help-block">{{ $errors->first($name) }}</span>
            </div>
        </div>
    @else
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif " >

            @if(isset($label))<label  class="control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif

            <div class="input-group">

                <input  id="{{$id}}" name="{{$name}}" @if(isset($vue)) v-model="{{$name}}" @endif  type="number"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                        @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                        @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                        class=" form-control @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                        @if(isset($required) && $required==true) required="required" @endif
                        value="{{ old($name, isset($value)?$value:null) }}"

                        @if(isset($data_attributes))
                        @foreach($data_attributes as $attr_name=>$attr_value)
                        data-{{$attr_name}}="{{$attr_value}}"
                        @endforeach
                        @endif

                        @if(isset($min)) min='{{$min}}' @endif
                        @if(isset($max)) max='{{$max}}' @endif
                        @if(isset($step)) step='{{$step}}' @endif
                >
                @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
            </div>

            <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>
        </div>

    @endif
@endif

{{--INPUT TYPE PASSWORD-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-10] (Optional)                   *
*   Icon (Optional)                         *
*   Class (Optional)                        *
*   Value (Optional)                        *
*   Mask (Optional)                         *
*   Placeholder (Optional)                  *
*   Tooltip (Optional)                      *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='password')

    @if(!isset($name))@php $name = $id; @endphp @endif

    @if(isset($aling) && $aling=='horizontal')

        <div id="@if(isset($block_id)){{$block_id}} @endif" class="form-group @if(isset($col)) col-md-{{$col}} @endif"@if(isset($hidden)) style="display: none"@endif>
            @if(isset($label))<label  class="control-label col-md-2 {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input @if(isset($readonly) && $readonly==true)readonly="readonly" @endif @if(isset($disabled) && $disabled==true)disabled="disabled" @endif id="{{$id}}"  class=" form-control @if(isset($class)){{$class}}@endif"  @if(isset($required) && $required==true) required="required" @endif type="password" name="{{$name}}" placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif" value="{{ old($name, isset($value)?$value:null) }}" @if(isset($mask)))data-mask="{{$mask}}" @endif>
                            @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
                        </div>
                    </div>
                </div>
                <span id="{{$id}}-error" class="help-block">{{ $errors->first($name) }}</span>
            </div>
        </div>
    @else
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif " >

            @if(isset($label))<label  class="control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif

            <div class="input-group">

                <input  id="{{$id}}" name="{{$name}}"  type="password"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                        @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                        @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                        class=" form-control @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                        @if(isset($required) && $required==true) required="required" @endif
                        value="{{ old($name, isset($value)?$value:null) }}"

                        @if(isset($data_attributes))
                        @foreach($data_attributes as $attr_name=>$attr_value)
                        data-{{$attr_name}}="{{$attr_value}}"
                        @endforeach
                        @endif
                >
                @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
            </div>

            <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>
        </div>

    @endif
@endif

{{--INPUT TYPE EMAIL-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-10] (Optional)                   *
*   Icon (Optional)                         *
*   Class (Optional)                        *
*   Value (Optional)                        *
*   Mask (Optional)                         *
*   Placeholder (Optional)                  *
*   Tooltip (Optional)                      *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='email')
    @if(!isset($name))@php $name = $id; @endphp @endif

    @if(isset($aling) && $aling=='horizontal')

        <div id="@if(isset($block_id)){{$block_id}} @endif" class="form-group @if(isset($col)) col-md-{{$col}} @endif"@if(isset($hidden)) style="display: none"@endif>
            @if(isset($label))<label  class="control-label col-md-2 {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input @if(isset($readonly) && $readonly==true)readonly="readonly" @endif @if(isset($disabled) && $disabled==true)disabled="disabled" @endif id="{{$id}}"  class=" form-control @if(isset($class)){{$class}}@endif"  @if(isset($required) && $required==true) required="required" @endif type="email" name="{{$name}}" placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif" value="{{ old($name, isset($value)?$value:null) }}" >
                            @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
                        </div>
                    </div>
                </div>
                <span id="{{$id}}-error" class="help-block">{{ $errors->first($name) }}</span>
            </div>
        </div>
    @else
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif " >

            @if(isset($label))<label  class="control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif

            <div class="input-group">

                <input  id="{{$id}}" name="{{$name}}"  type="email"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                        @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                        @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                        class=" form-control @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                        @if(isset($required) && $required==true) required="required" @endif
                        value="{{ old($name, isset($value)?$value:null) }}"

                        @if(isset($data_attributes))
                        @foreach($data_attributes as $attr_name=>$attr_value)
                        data-{{$attr_name}}="{{$attr_value}}"
                        @endforeach
                        @endif
                >
                @if(isset($icon))<span class="input-group-addon"><i class="{{$icon}}"></i></span>@endif
            </div>

            <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>
        </div>

    @endif
@endif

{{--INPUT TYPE CHECKBOX-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-10] (Optional)                   *
*   Icon (Optional)                         *
*   Class (Optional)                        *
*   Value (Optional)                        *
*   Mask (Optional)                         *
*   Placeholder (Optional)                  *
*   Tooltip (Optional)                      *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='checkbox')
    @if(!isset($name))@php $name = $id; @endphp @endif
    @if(isset($aling) && $aling=='horizontal')

        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif "
        >
            @if(isset($label))<label  class=" col-md-2 control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">
                <label class="checkbox-inline">
                    <input type="checkbox"
                           id="{{$id}}" name="{{$name}}"
                           class="checkbox style-0 @if(isset($class)){{$class}}@endif"
                           @if(isset($checked) && $checked) checked="checked" @endif
                           @if(isset($required) && $required==true) required="required" @endif
                           @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                           @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                           value="{{ old($name, isset($value)?$value:null) }}"
                           @if(isset($data_attributes))
                           @foreach($data_attributes as $attr_name=>$attr_value)
                           data-{{$attr_name}}="{{$attr_value}}"
                            @endforeach
                            @endif
                    >
                </label>
                <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }}  </span>

            </div>
        </div>



    @else

        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif "
        >

        @if(isset($label))<label  class=" col-md-12 control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif

            <div class="col-md-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               id="{{$id}}" name="{{$name}}"
                               class="checkbox style-0 @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                               @if(isset($checked) && $checked) checked="checked" @endif
                               @if(isset($required) && $required==true) required="required" @endif
                               @if(isset($readonly) && $readonly==true) readonly="readonly"  onclick="javascript: return false;" @endif
                               @if(isset($disabled) && $disabled==true) disabled="disabled" @endif
                               value="{{ old($name, isset($value)?$value:null) }}"
                               @if(isset($data_attributes))
                                   @foreach($data_attributes as $attr_name=>$attr_value)
                                   data-{{$attr_name}}="{{$attr_value}}"
                                   @endforeach
                               @endif
                        >
                        <span>{{$texto}}</span>
                    </label>
                    <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }}  </span>
                </div>
            </div>
        </div>


    @endif
@endif



{{--INPUT TYPE radio-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-10] (Optional)                   *
*   Icon (Optional)                         *
*   Class (Optional)                        *
*   Value (Optional)                        *
*   Mask (Optional)                         *
*   Placeholder (Optional)                  *
*   Tooltip (Optional)                      *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='radio')
    @if(!isset($name))@php $name = $id; @endphp @endif
    @if(isset($aling) && $aling=='horizontal')

        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif "
        >
            @if(isset($label))<label  class=" col-md-2 control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">
                <label class="radio-inline">
                    <input type="radio"
                           id="{{$id}}" name="{{$name}}"
                           class="radiobox style-0  @if(isset($class)){{$class}}@endif"
                           @if(isset($checked) && $checked) checked="checked" @endif
                           @if(isset($required) && $required==true) required="required" @endif
                           @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                           @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                           value="{{ old($name, isset($value)?$value:null) }}"
                           @if(isset($data_attributes))
                           @foreach($data_attributes as $attr_name=>$attr_value)
                           data-{{$attr_name}}="{{$attr_value}}"
                            @endforeach
                            @endif
                    >
                    <span>{{$texto}}</span>
                </label>
                <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }}  </span>

            </div>
        </div>

    @else

        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif "
        >
            @if(isset($label))<label  class=" col-md-12 control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-12">
                <div class="radio">
                    <label>
                        <input type="radio"
                               id="{{$id}}" name="{{$name}}"
                               class="radiobox style-0 @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                               @if(isset($checked) && $checked) checked="checked" @endif
                               @if(isset($required) && $required==true) required="required" @endif
                               @if(isset($readonly) && $readonly==true)  readonly="readonly"  onclick="javascript: return false;" @endif
                               @if(isset($disabled) && $disabled==true) disabled="disabled" @endif
                               value="{{ old($name, isset($value)?$value:null) }}"
                               @if(isset($data_attributes))
                               @foreach($data_attributes as $attr_name=>$attr_value)
                               data-{{$attr_name}}="{{$attr_value}}"
                                @endforeach
                                @endif
                        >
                        <span>{{$texto}}</span>
                    </label>
                    <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>
                </div>
            </div>
        </div>

    @endif
@endif




{{--INPUT TYPE TEXTAREA-------------------------*
*----PARAMS---------------------------------*
*   Type (Required)                         *
*   Id (Required)                           *
*   Name (Required)                         *
*   Label (Optional)                        *
*   Require[true-false] (Optional)          *
*   Readonly[true-false] (Optional)         *
*   Disabled[true-false] (Optional)         *
*   Col [1-12] (Optional)                   *
*   Class (Optional)                        *
*   Align [horizontal-vertical](Optional)   *--}}
@if($type=='textarea')
    @if(!isset($name))@php $name = $id; @endphp @endif
    @if(isset($aling) && $aling=='horizontal')
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif "
        >
            @if(isset($label))<label  class="col-md-2 control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class="col-md-10">
            <textarea @if(isset($rows)) rows="{{$rows}}"  @else rows="3" @endif
            id="{{$id}}" name="{{$name}}"  type="number"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                      @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                      @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                      class=" form-control @if(isset($class)){{$class}}@endif"
                      @if(isset($required) && $required==true) required="required" @endif
                      @if(isset($data_attributes))
                      @foreach($data_attributes as $attr_name=>$attr_value)
                      data-{{$attr_name}}="{{$attr_value}}"
                    @endforeach
                    @endif
            >{{ old($name, isset($value)?$value:null) }}</textarea>
            </div>
                <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>

        </div>
    @else
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'has-error has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif @if(!empty($errors->first($name))) is-invalid @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif "
        >
            @if(isset($label))<label  class="control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <textarea @if(isset($rows)) rows="{{$rows}}"  @else rows="3" @endif
                      id="{{$id}}" name="{{$name}}"  type="number"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                      @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                      @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                      class=" form-control @if(isset($class)){{$class}}@endif @if(!empty($errors->first($name))) is-invalid @endif"
                      @if(isset($required) && $required==true) required="required" @endif
                      @if(isset($data_attributes))
                      @foreach($data_attributes as $attr_name=>$attr_value)
                      data-{{$attr_name}}="{{$attr_value}}"
                    @endforeach
                    @endif
            >{{ old($name, isset($value)?$value:null) }}</textarea>
                <span id="{{$id}}-error" class="help-block invalid-feedback">{{ $errors->first($name) }} </span>
        </div>
    @endif
@endif


{{--Input type  date--}}
@if($type=='date')
    @if(!isset($name))@php $name = $id; @endphp @endif
    @if(isset($aling) && $aling=='horizontal')
    @else
        <div id="@if(isset($block_id)){{$block_id}}@endif"
             class="form-group  {{ $errors->has($name) ? 'is-invalid has-feedback' : '' }} margin-bottom-10  @if(isset($col)) col-md-{{$col}} @endif"
             style="margin-bottom:16px !important; @if(isset($hidden))display: none @endif " >

            @if(isset($label))<label  class="control-label {{ $errors->has($name) ? 'state-error' : '' }}">{{ Lang::get($label) }}</label>@endif
            <div class='input-group date'>
                <input id="{{$id}}" name="{{$name}}"  type="text"  placeholder="@if(isset($placeholder)){{ Lang::get($placeholder)  }}@else{{isset($label)?Lang::get($label):null}}@endif"
                @if(isset($readonly) && $readonly==true)readonly="readonly" @endif
                @if(isset($disabled) && $disabled==true)disabled="disabled" @endif
                class=" form-control  datetimepicker @if(isset($class)){{$class}}@endif"
                @if(isset($required) && $required==true) required="required" @endif
                value="{{ old($name, isset($value)?$value:null) }}"
                @if(isset($data_attributes))
                    @foreach($data_attributes as $attr_name=>$attr_value)
                        data-{{$attr_name}}="{{$attr_value}}"
                    @endforeach
                @endif
                >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
            <span class="help-block invalid-feedback">{{ $errors->first($name) }}</span>
        </div>
    @endif
@endif
{{--Input type  date label up--}}
@if($type=='date_label_up')

@endif