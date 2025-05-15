@extends('admin.layouts.body')
@section('title', 'Lixeira de Pagamentos')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.pagamento.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Pagamentos Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fatura</th>
            <th>Data Pagamento</th>
            <th>Valor Pago</th>
            <th>Método Pagamento</th>
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
            <td>
                <form id="restore-form-{{ $pagamento->id }}" action="{{ route('admin.pagamento.restore', $pagamento->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $pagamento->id }})">Restaurar</button>

                <form id="purge-form-{{ $pagamento->id }}" action="{{ route('admin.pagamento.purge', $pagamento->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $pagamento->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este pagamento?",
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
            text: "Esta ação excluirá permanentemente o pagamento!",
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