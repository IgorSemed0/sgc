@extends('admin.layouts.body')
@section('title', 'Lixeira de Comentários de Chat')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.chat-comentario.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Comentários de Chat Apagados</h1>
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
                <form id="restore-form-{{ $chatComentario->id }}" action="{{ route('admin.chat-comentario.restore', $chatComentario->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $chatComentario->id }})">Restaurar</button>

                <form id="purge-form-{{ $chatComentario->id }}" action="{{ route('admin.chat-comentario.purge', $chatComentario->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $chatComentario->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este comentário de chat?",
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
            text: "Esta ação excluirá permanentemente o comentário de chat!",
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