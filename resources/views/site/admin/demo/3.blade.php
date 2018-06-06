<table class="table table-striped">
    <thead>
    <tr>
        <td>User</td>
        <td>Email</td>
        <td>Degree</td>
    </tr>
    </thead>
    <tbody>
    @foreach(App\User::latest()->get()->take(5) as $user)
        <tr class="font-weight-bold">
            <td>{{$user->getFullName()}}</td>
            <td>{{$user->getEmail()}}</td>
            <td>{{$user->getDegree->getName()}}</td>
        </tr>
    @endforeach
    </tbody>
</table>