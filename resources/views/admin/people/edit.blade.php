@extends('adminlte::page')

@section('title', 'Editar Pessoa')

@section('content_header')
    <h1><a href="{{ route('people.index') }}" class="btn btn-primary"><i class="fas fa-chevron-circle-left"></i></a>
        Editar Pessoa
        <button type="submit" id="btnSave" class="btn btn-success float-right " onclick="submitForm()">Salvar</button>
    </h1>
@stop

@section('content')
    <form action="{{ route('people.update', $people->id) }}" method="POST" id="form" class="form">
        <div class="card card-body">
            @csrf
            @method('PUT')

            @include('admin.people._partials.form')
        </div>
        <div class="card">
            <div class="card-header">
                <button type="button" id="addFone" onclick="addContact()" class="btn btn-info"><i
                        class="fas fa-plus-circle"></i>
                </button>
                Telefones
            </div>
            <div class="card-body div-contact form-inline">
                @include('admin.people._partials.formContacts')
            </div>
        </div>
    </form>
@stop

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="{{ asset('js/util/submitForm.js') }}"></script>
<script src="{{ asset('js/admin/people/validationContacts.js') }}"></script>
