<table class="table table-striped">
    <thead>
    <tr>
        <td>Subject</td>
        <td>Group #</td>
        <td>Coordinator</td>
        <td>Theory Lecturer</td>
        <td>Practice Lecturer</td>
        <td>Student</td>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr class="font-weight-bold">
            <td>{{$group->getSubjectInstance->getSubject->getName()}}</td>
            <td>{{$group->getNumber()}}</td>
            @if(!is_null($group->getSubjectInstance->getSubject->getCoordinator))
                <td>{{$group->getSubjectInstance->getSubject->getCoordinator->getEmail()}}</td>
            @else
                <td></td>
            @endif
            @if(!is_null($group->getTheoryLecturer))
                <td>{{$group->getTheoryLecturer->getEmail()}}</td>
            @else
                <td></td>
            @endif
            @if(!is_null($group->getPracticeLecturer))
                <td>{{$group->getPracticeLecturer->getEmail()}}</td>
            @else
                <td></td>
            @endif
            <td></td>
        </tr>
        @foreach($group->getStudents as $student)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$student->getEmail()}}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>