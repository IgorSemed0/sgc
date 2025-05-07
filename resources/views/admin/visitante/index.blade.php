@extends('admin.layouts.body')
@section('title', 'Listar Visitantes')
@section('conteudo')
<h1 class="h3">Tabela de Visitantes</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#visitanteModal">Novo Visitante</button>
    <a href="{{ route('admin.visitante.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>BI</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Motivo da Visita</th>
                <th>Data Entrada</th>
                <th>Data Saída</th>
                <th>Unidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitantes as $visitante)
            <tr>
                <td>{{ $visitante->id }}</td>
                <td>{{ $visitante->primeiro_nome }} {{ $visitante->nomes_meio }} {{ $visitante->ultimo_nome }}</td>
                <td>{{ $visitante->bi }}</td>
                <td>{{ $visitante->email }}</td>
                <td>{{ $visitante->telefone }}</td>
                <td>{{ $visitante->motivo_visita }}</td>
                <td>{{ $visitante->data_entrada }}</td>
                <td>{{ $visitante->data_saida }}</td>
                <td>{{ $visitante->unidade->tipo }} - {{ $visitante->unidade->numero }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $visitante->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.visitante.destroy', $visitante->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $visitante->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $visitante->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Visitante</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.visitante.editar.index', ['visitante' => $visitante])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="visitanteModal" tabindex="-1" aria-labelledby="visitanteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Visitante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.visitante.cadastrar.index')
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