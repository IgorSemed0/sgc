@extends('admin.layouts.body')
@section('title', 'Lixeira de Espaços Comuns')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.espaco-comum.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Espaços Comuns Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Condomínio</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Capacidade</th>
            <th>Regras</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($espacoComums as $espacoComum)
        <tr>
            <td>{{ $espacoComum->id }}</td>
            <td>{{ $espacoComum->condominio->nome }}</td>
            <td>{{ $espacoComum->nome }}</td>
            <td>{{ $espacoComum->descricao ?? '-' }}</td>
            <td>{{ $espacoComum->capacidade }}</td>
            <td>{{ $espacoComum->regras ?? '-' }}</td>
            <td>
                <form id="restore-form-{{ $espacoComum->id }}" action="{{ route('admin.espaco-comum.restore', $espacoComum->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $espacoComum->id }})">Restaurar</button>

                <form id="purge-form-{{ $espacoComum->id }}" action="{{ route('admin.espaco-comum.purge', $espacoComum->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $espacoComum->id }})">Excluir Permanentemente</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if (session('success'))
<script>
    Swal.fire({
        title: "Sucesso!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "OK"
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        title: "Erro!",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonText: "OK"
    });
</script>
@endif

<script>
    function confirmRestore(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja restaurar este espaço comum?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, restaurar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`restore-form-${id}`).submit();
            }
        });
    }

    function confirmPurge(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação excluirá permanentemente o espaço comum!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`purge-form-${id}`).submit();
            }
        });
    }
</script>
@endsection