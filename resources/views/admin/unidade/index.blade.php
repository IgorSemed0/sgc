@extends('admin.layouts.body')
@section('title', 'Listar Unidades')
@section('conteudo')
<h1 class="h3">Tabela de Unidades</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unidadeModal">Nova Unidade</button>
    <a href="{{ route('admin.unidade.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Bloco</th>
                <th>Edifício</th>
                <th>Área (m²)</th>
                <th>Andar</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unidades as $unidade)
            <tr>
                <td>{{ $unidade->id }}</td>
                <td>{{ $unidade->tipo }}</td>
                <td>{{ $unidade->numero }}</td>
                <td>{{ $unidade->bloco->nome }}</td>
                <td>{{ $unidade->edificio->nome }}</td>
                <td>{{ $unidade->area_m2 }}</td>
                <td>{{ $unidade->andar }}</td>
                <td>{{ $unidade->status }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $unidade->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.unidade.destroy', $unidade->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $unidade->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $unidade->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Unidade</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.unidade.editar.index', ['unidade' => $unidade])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="unidadeModal" tabindex="-1" aria-labelledby="unidadeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Unidade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.unidade.cadastrar.index')
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