@extends('admin.layouts.body')
@section('title', 'Listar Comentários de Chat')
@section('conteudo')
<h1 class="h3">Tabela de Comentários de Chat</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chatComentarioModal">Novo Comentário de Chat</button>
    <a href="{{ route('admin.chat-comentario.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Post</th>
                <th>Usuário</th>
                <th>Conteúdo</th>
                <th>Data Comentário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chatComentarios as $chatComentario)
            <tr>
                <td>{{ $chatComentario->id }}</td>
                <td>{{ $chatComentario->chatPost->titulo }}</td>
                <td>{{ $chatComentario->user->full_name }}</td>
                <td>{{ Str::limit($chatComentario->conteudo, 50) }}</td>
                <td>{{ \Carbon\Carbon::parse($chatComentario->data_comentario)->format('d/m/Y H:i') }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $chatComentario->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.chat-comentario.destroy', $chatComentario->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $chatComentario->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $chatComentario->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Comentário de Chat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.chat-comentario.editar.index', ['chatComentario' => $chatComentario])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="chatComentarioModal" tabindex="-1" aria-labelledby="chatComentarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Comentário de Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.chat-comentario.cadastrar.index')
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