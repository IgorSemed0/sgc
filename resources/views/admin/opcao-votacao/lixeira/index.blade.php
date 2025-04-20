@extends('admin.layouts.body')
@section('title', 'Lixeira de Opções de Votação')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.opcao-votacao.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Opções de Votação Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Votação</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($opcaoVotacaos as $opcaoVotacao)
        <tr>
            <td>{{ $opcaoVotacao->id }}</td>
            <td>{{ $opcaoVotacao->votacao->titulo }}</td>
            <td>{{ $opcaoVotacao->descricao }}</td>
            <td>
                <form id="restore-form-{{ $opcaoVotacao->id }}" action="{{ route('admin.opcao-votacao.restore', $opcaoVotacao->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $opcaoVotacao->id }})">Restaurar</button>

                <form id="purge-form-{{ $opcaoVotacao->id }}" action="{{ route('admin.opcao-votacao.purge', $opcaoVotacao->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $opcaoVotacao->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta opção de votação?",
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
            text: "Esta ação excluirá permanentemente a opção de votação!",
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