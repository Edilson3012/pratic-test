@extends('adminlte::page')

@section('title', 'Detalhes da Pessoa')

@section('content_header')
    <h1>
        <a href="{{ route('people.index') }}" class="btn btn-primary"><i class="fas fa-chevron-circle-left"></i></a>
        Ver detalhes da Pessoa - {{ $people->name }}
    </h1>
@stop

@section('content')
    <div class="card card-body">
        <table class="table table-striped">
            <thead>
                <th>Nome</th>
                <th>Documento</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $people->name }}</td>
                    <td>{{ $people->document }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if (isset($contacts[0]))
        <div class="card card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Contatos</th>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->fone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@stop
