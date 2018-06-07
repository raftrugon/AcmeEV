<select class="selectpicker chat-picker dropup" data-size="5" data-width="fit" data-style="btn-dark">
    <option value="" selected disabled data-content="<i class='fas fa-plus' style='color:#28a745'></i>"></option>
    @foreach($users as $user)
        <option value="{{$user->id}}">{{$user->getSurname()}}, {{$user->getName()}}</option>
    @endforeach
</select>
@php($groupsStr = '')
@foreach($conversations as $conversation)
    @if(is_null($conversation->getGroup))
        <a data-id="{{$conversation->getId()}}" class="chat-tab">{{$conversation->getName()}} @if($conversation->isUnread())<span class="not-read-badge badge badge-primary">!</span> @endif</a>
    @else
        @php($groupsStr .= '<a href="#" data-id=\''.$conversation->getId().'\' class=\'nav-link chat-tab\'>'.$conversation->getName().'</a>')
    @endif
@endforeach
@hasanyrole('pdi|student')
    <a tabindex="0" class="groups-tab chat-tab" data-toggle="popover" data-placement="top" data-content="{{$groupsStr}}">@lang('chat.groups.link')</a>
@endhasanyrole