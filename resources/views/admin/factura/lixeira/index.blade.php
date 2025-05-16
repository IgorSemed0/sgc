@extends('admin.layouts.body')
@section('title', 'Lixeira de Cobranças')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.factura.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Cobranças Apagadas</h1>
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
            <td>{{ $factura->status }}</td>
            <td>{{ $factura->observacao }}</td>
            <td>
                <form id="restore-form-{{ $factura->id }}" action="{{ route('admin.factura.restore', $factura->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $factura->id }})">Restaurar</button>

                <form id="purge-form-{{ $factura->id }}" action="{{ route('admin.factura.purge', $factura->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $factura->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta fatura?",
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
            text: "Esta ação excluirá permanentemente a fatura!",
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