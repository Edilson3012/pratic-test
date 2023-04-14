@extends('adminlte::page')

@section('title', 'Pessoas')

@section('content_header')
    <h1><a href="{{ route('people.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i></a>
        Pessoas </h1>
@stop

@section('content')
    @include('includes.alerts')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('people.search') }}" class="form form-inline" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="filter" value="{{ $filters['filter'] ?? null }}" placeholder="Buscar Pessoa"
                        class="form-control">&nbsp;
                </div>
                <button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i></button>
            </form>

        </div>
        <div class="card-body">
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>Documento</th>
                    <th style="text-align: center; width: 20%;">Ações</th>
                </thead>
                @foreach ($peoples as $people)
                    <tr id="line-people-{{ $people->id }}">
                        <td>{{ $people->name }}</td>
                        <td>{{ $people->document }}</td>
                        <td style="margin-right: 50px">
                            <div class="form-group">

                                <a href="{{ route('people.show', $people->id) }}" class="btn btn-primary "><i
                                        class="fas fa-eye"></i></a>
                                <a href="{{ route('people.edit', $people->id) }}" class="btn btn-warning "><i
                                        class="fas fa-edit"></i></a>

                                <button class="btn btn-danger" onclick="deleteConfirmation('{{ $people->id }}')"><i
                                        class="fas fa-trash-alt"></i></button>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@stop

<script src="{{ asset('js/admin/people/index.js') }}"></script>
