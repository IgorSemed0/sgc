@extends('admin.layouts.body')
@section('title', 'Lixeira de Condomínios')
@section('conteudo')
<h1 class="h3">Condomínios Apagados</h1>
<table class="table table-striped myTable">
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
                <form action="{{ route('admin.condominio.restore', $condominio->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                </form>
                <form action="{{ route('admin.condominio.purge', $condominio->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir permanentemente este condomínio?')">Excluir Permanentemente</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection