@extends('admin.layouts.body')
@section('title', 'Lixeira de Movimentos')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.movimento.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Movimentos Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Conta</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Descrição</th>
            <th>Data Movimento</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movimentos as $movimento)
        <tr>
            <td>{{ $movimento->id }}</td>
            <td>{{ $movimento->conta->nome }}</td>
            <td>{{ $movimento->tipo }}</td>
            <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
            <td>{{ $movimento->descricao ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($movimento->data_movimento)->format('d/m/Y') }}</td>
            <td>
                <form id="restore-form-{{ $movimento->id }}" action="{{ route('admin.movimento.restore', $movimento->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $movimento->id }})">Restaurar</button>

                <form id="purge-form-{{ $movimento->id }}" action="{{ route('admin.movimento.purge', $movimento->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $movimento->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este movimento?",
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
            text: "Esta ação excluirá permanentemente o movimento!",
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