@extends('admin.layouts.body')
@section('title', 'Listar Votações')
@section('conteudo')
<h1 class="h3">Tabela de Votações</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#votacaoModal">Nova Votação</button>
    <a href="{{ route('admin.votacao.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Condomínio</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Quórum Mínimo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($votacaos as $votacao)
            <tr>
                <td>{{ $votacao->id }}</td>
                <td>{{ $votacao->titulo }}</td>
                <td>{{ $votacao->descricao }}</td>
                <td>{{ \Carbon\Carbon::parse($votacao->data_inicio)->format('d/m/Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($votacao->data_fim)->format('d/m/Y H:i') }}</td>
                <td>{{ $votacao->quorum_minimo ?? '-' }}</td>
                <td>{{ $votacao->status }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $votacao->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.votacao.destroy', $votacao->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $votacao->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $votacao->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Votação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.votacao.editar.index', ['votacao' => $votacao])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="votacaoModal" tabindex="-1" aria-labelledby="votacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Votação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.votacao.cadastrar.index')
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