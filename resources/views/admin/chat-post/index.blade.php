@extends('admin.layouts.body')
@section('title', 'Listar Posts de Chat')
@section('conteudo')
<h1 class="h3">Tabela de Posts de Chat</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chatPostModal">Novo Post de Chat</button>
    <a href="{{ route('admin.chat-post.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
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
       。五
        <tbody>
            @foreach ($chatPosts as $chatPost)
            <tr>
                <td>{{ $chatPost->id }}</td>
                <td>
                    {{ $chatPost->user->primeiro_nome ?? '' }} 
                    {{ $chatPost->user->nomes_meio ?? '' }} 
                    {{ $chatPost->user->ultimo_nome ?? '' }}
                </td>                
                <td>{{ $chatPost->tipo_autor }}</td>
                <td>{{ $chatPost->titulo }}</td>
                <td>{{ Str::limit($chatPost->conteudo, 50) }}</td>
                <td>{{ \Carbon\Carbon::parse($chatPost->data_publicacao)->format('d/m/Y H:i') }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $chatPost->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.chat-post.destroy', $chatPost->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $chatPost->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $chatPost->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Post de Chat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.chat-post.editar.index', ['chatPost' => $chatPost])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="chatPostModal" tabindex="-1" aria-labelledby="chatPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Post de Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.chat-post.cadastrar.index')
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