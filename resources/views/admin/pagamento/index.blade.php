@extends('admin.layouts.body')
@section('title', 'Listar Pagamentos')
@section('conteudo')
<h1 class="h3">Tabela de Pagamentos</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagamentoModal">Novo Pagamento</button>
    <a href="{{ route('admin.pagamento.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fatura</th>
                <th>Data Pagamento</th>
                <th>Valor Pago</th>
                <th>Método Pagamento</th>
                <th>Transação ID</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagamentos as $pagamento)
            <tr>
                <td>{{ $pagamento->id }}</td>
                <td>{{ $pagamento->factura->referencia }}</td>
                <td>{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}</td>
                <td>{{ number_format($pagamento->valor_pago, 2, ',', '.') }}</td>
                <td>{{ $pagamento->metodo_pagamento }}</td>
                <td>{{ $pagamento->transacao_id ?? '-' }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $pagamento->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.pagamento.destroy', $pagamento->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $pagamento->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $pagamento->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Pagamento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.pagamento.editar.index', ['pagamento' => $pagamento])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="pagamentoModal" tabindex="-1" aria-labelledby="pagamentoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.pagamento.cadastrar.index')
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