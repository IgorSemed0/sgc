@extends('admin.layouts.body')
@section('title', 'Listar Despesas')
@section('conteudo')
<h1 class="h3">Tabela de Despesas</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#despesaModal">Nova Despesa</button>
    <a href="{{ route('admin.despesa.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data Despesa</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($despesas as $despesa)
            <tr>
                <td>{{ $despesa->id }}</td>
                <td>{{ $despesa->descricao }}</td>
                <td>{{ number_format($despesa->valor, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($despesa->data_despesa)->format('d/m/Y') }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $despesa->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.despesa.destroy', $despesa->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $despesa->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $despesa->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Despesa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.despesa.editar.index', ['despesa' => $despesa])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="despesaModal" tabindex="-1" aria-labelledby="despesaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Despesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.despesa.cadastrar.index')
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