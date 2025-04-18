@extends('admin.layouts.body')
@section('title', 'Cadastrar Condomínio')
@section('conteudo')
<form action="{{ route('admin.condominio.store') }}" method="POST">
    @csrf
    @include('admin._form.condominio.index')
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection