@extends('admin.layouts.body')
@section('title', 'Listar Opções de Votação')
@section('conteudo')
<h1 class="h3">Tabela de Opções de Votação</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#opcaoVotacaoModal">Nova Opção de Votação</button>
    <a href="{{ route('admin.opcao-votacao.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
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
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $opcaoVotacao->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.opcao-votacao.destroy', $opcaoVotacao->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $opcaoVotacao->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $opcaoVotacao->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Opção de Votação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.opcao-votacao.editar.index', ['opcaoVotacao' => $opcaoVotacao])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="opcaoVotacaoModal" tabindex="-1" aria-labelledby="opcaoVotacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Opção de Votação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.opcao-votacao.cadastrar.index')
            </div>
        </div>
    </div>
</div>

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
    function confirmDelete(url) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection