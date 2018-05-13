@extends('layouts.pdf-default')

@section('content')

    @foreach($degrees as $degree => $inscriptions)

        <h4 class="text-center">{{$degree}}</h4>

        <table class="table table-striped table-borderless table-sm mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre y Apellidos</th>
                    <th>Nº Identificación</th>
                    <th>Nota</th>
                </tr>
            </thead>
            @foreach($inscriptions as $inscription)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$inscription->getFullName()}}</td>
                    <td>{{$inscription->getIdNumber()}}</td>
                    <td>{{$inscription->getGrade()}}</td>
                </tr>
            @endforeach
        </table>
        <div class="page-break"></div>
    @endforeach

@endsection