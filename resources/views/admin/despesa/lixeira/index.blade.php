@extends('admin.layouts.body')
@section('title', 'Lixeira de Despesas')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.despesa.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Despesas Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Condomínio</th>
            <th>Categoria</th>
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
            <td>{{ $despesa->categoria }}</td>
            <td>{{ $despesa->descricao }}</td>
            <td>{{ number_format($despesa->valor, 2, ',', '.') }}</td>
            <td>{{ \Carbon\Carbon::parse($despesa->data_despesa)->format('d/m/Y') }}</td>
            <td>
                <form id="restore-form-{{ $despesa->id }}" action="{{ route('admin.despesa.restore', $despesa->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $despesa->id }})">Restaurar</button>

                <form id="purge-form-{{ $despesa->id }}" action="{{ route('admin.despesa.purge', $despesa->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $despesa->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta despesa?",
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
            text: "Esta ação excluirá permanentemente a despesa!",
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