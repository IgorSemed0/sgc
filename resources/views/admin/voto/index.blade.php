@extends('admin.layouts.body')
@section('title', 'Listar Votos')
@section('conteudo')
<h1 class="h3">Tabela de Votos</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#votoModal">Novo Voto</button>
    <a href="{{ route('admin.voto.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Votação</th>
                <th>Usuário</th>
                <th>Opção</th>
                <th>Data/Hora</th>
                <th>Hash Voto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($votos as $voto)
            <tr>
                <td>{{ $voto->id }}</td>
                <td>{{ $voto->votacao->titulo }}</td>
                <td>{{ $voto->user->full_name }}</td>
                <td>{{ $voto->opcaoVotacao->descricao }}</td>
                <td>{{ \Carbon\Carbon::parse($voto->data_hora)->format('d/m/Y H:i') }}</td>
                <td>{{ $voto->hash_voto ?? '-' }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $voto->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.voto.destroy', $voto->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $voto->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $voto->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Voto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.voto.editar.index', ['voto' => $voto])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="votoModal" tabindex="-1" aria-labelledby="votoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Voto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.voto.cadastrar.index')
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