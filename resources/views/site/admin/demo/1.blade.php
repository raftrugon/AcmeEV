<table class="table table-striped">
    <thead>
        <tr>
            <td>user</td>
            <td>grade</td>
            <td>agreed</td>
            <td>degree</td>
        </tr>
    </thead>
    <tbody>
    @foreach($inscriptions as $inscription)
        <tr class="font-weight-bold">
            <td>{{$inscription->getIdNumber()}}</td>
            <td>{{$inscription->getGrade()}}</td>
            <td>{{$inscription->getAgreed()}}</td>
            <td></td>
        </tr>
        @foreach($inscription->getRequests as $request)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="@if($request->getAccepted())bg-success @else bg-danger @endif "  >{{$request->getDegree->getName()}}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>