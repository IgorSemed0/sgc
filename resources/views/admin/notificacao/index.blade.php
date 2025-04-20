@extends('admin.layouts.body')
@section('title', 'Listar Notificações')
@section('conteudo')
<h1 class="h3">Tabela de Notificações</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#notificacaoModal">Nova Notificação</button>
    <a href="{{ route('admin.notificacao.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Tipo</th>
                <th>Título</th>
                <th>Conteúdo</th>
                <th>Data/Hora</th>
                <th>Lida</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notificacaos as $notificacao)
            <tr>
                <td>{{ $notificacao->id }}</td>
                <td>{{ $notificacao->user->full_name }}</td>
                <td>{{ $notificacao->tipo }}</td>
                <td>{{ $notificacao->titulo }}</td>
                <td>{{ Str::limit($notificacao->conteudo, 50) }}</td>
                <td>{{ \Carbon\Carbon::parse($notificacao->data_hora)->format('d/m/Y H:i') }}</td>
                <td>{{ $notificacao->lida ? 'Sim' : 'Não' }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $notificacao->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.notificacao.destroy', $notificacao->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $notificacao->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $notificacao->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Notificação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.notificacao.editar.index', ['notificacao' => $notificacao])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="notificacaoModal" tabindex="-1" aria-labelledby="notificacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Notificação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.notificacao.cadastrar.index')
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