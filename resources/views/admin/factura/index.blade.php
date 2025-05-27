@extends('admin.layouts.body')
@section('title', 'Listar Cobranças')
@section('conteudo')
<h1 class="h3">Tabela de Cobranças</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#facturaModal">Nova Cobrança</button>
    <a href="{{ route('admin.factura.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
    <table class="table table-striped myTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Unidade</th>
                <th>Referência</th>
                <th>Data Emissão</th>
                <th>Data Vencimento</th>
                <th>Valor Total</th>
                <th>Status</th>
                <th>Observação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $factura)
            <tr>
                <td>{{ $factura->id }}</td>
                <td>{{ $factura->unidade->tipo }} - {{ $factura->unidade->numero }}</td>
                <td>{{ $factura->referencia }}</td>
                <td>{{ $factura->data_emissao }}</td>
                <td>{{ $factura->data_vencimento }}</td>
                <td>{{ $factura->valor_total }}</td>
                <td>
                    <span class="badge 
                        @if($factura->status == 'Pago') bg-success 
                        @elseif($factura->status == 'Pendente') bg-warning 
                        @else bg-danger 
                        @endif">
                        {{ $factura->status }}
                    </span>
                </td>
                <td>{{ $factura->observacao }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal{{ $factura->id }}" title="Atualizar Status">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $factura->id }}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.factura.destroy', $factura->id) }}')" title="Deletar">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>

            <!-- Status Update Modal -->
            <div class="modal fade" id="statusModal{{ $factura->id }}" tabindex="-1" aria-labelledby="statusModal{{ $factura->id }}Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Atualizar Status - Fatura #{{ $factura->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.factura.updateStatus', $factura->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="status{{ $factura->id }}" class="form-label">Novo Status</label>
                                    <select class="form-control" id="status{{ $factura->id }}" name="status" required>
                                        <option value="Pendente" {{ $factura->status == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="Pago" {{ $factura->status == 'Pago' ? 'selected' : '' }}>Pago</option>
                                        <option value="Cancelado" {{ $factura->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </div>
                                <div class="alert alert-info">
                                    <strong>Status Atual:</strong> {{ $factura->status }}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Atualizar Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editar_modal{{ $factura->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $factura->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Cobrança</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.factura.editar.index', ['factura' => $factura])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Create Modal -->
    <div class="modal fade" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Cobrança</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.factura.cadastrar.index')
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