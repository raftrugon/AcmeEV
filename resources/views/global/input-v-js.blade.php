
var {{$id}} = new Vue({
        el: '#{{$id}}',
        data: {
            @foreach($inputs as $i)
            {{$i}}: '{{old($i)}}',
            @endforeach
        }
});