@extends('admin.layouts.body')
@section('title', 'Listar Condomínios')
@section('conteudo')
<h1 class="h3">Tabela de Condomínios</h1>
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.condominio.create') }}" class="btn btn-primary">Novo Condomínio</a>
    <a href="{{ route('admin.condominio.trash') }}" class="btn btn-secondary">Lixeira</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($condominios as $condominio)
        <tr>
            <td>{{ $condominio->id }}</td>
            <td>{{ $condominio->nome }}</td>
            <td>{{ $condominio->cidade }}</td>
            <td>{{ $condominio->estado }}</td>
            <td>
                <a href="{{ route('admin.condominio.edit', $condominio->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <a href="{{ route('admin.condominio.destroy', $condominio->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este condomínio?')">Excluir</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection