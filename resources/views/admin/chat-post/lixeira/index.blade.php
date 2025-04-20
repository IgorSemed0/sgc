@extends('admin.layouts.body')
@section('title', 'Lixeira de Posts de Chat')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.chat-post.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Posts de Chat Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Condomínio</th>
            <th>Autor</th>
            <th>Tipo Autor</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Data Publicação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($chatPosts as $chatPost)
        <tr>
            <td>{{ $chatPost->id }}</td>
            <td>{{ $chatPost->condominio->nome }}</td>
            <td>{{ $chatPost->user->full_name }}</td>
            <td>{{ $chatPost->tipo_autor }}</td>
            <td>{{ $chatPost->titulo }}</td>
            <td>{{ Str::limit($chatPost->conteudo, 50) }}</td>
            <td>{{ \Carbon\Carbon::parse($chatPost->data_publicacao)->format('d/m/Y H:i') }}</td>
            <td>
                <form id="restore-form-{{ $chatPost->id }}" action="{{ route('admin.chat-post.restore', $chatPost->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $chatPost->id }})">Restaurar</button>

                <form id="purge-form-{{ $chatPost->id }}" action="{{ route('admin.chat-post.purge', $chatPost->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $chatPost->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este post de chat?",
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
            text: "Esta ação excluirá permanentemente o post de chat!",
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