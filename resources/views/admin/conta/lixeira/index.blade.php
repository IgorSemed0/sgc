@extends('admin.layouts.body')
@section('title', 'Lixeira de Contas')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.conta.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Contas Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Condomínio</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Saldo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contas as $conta)
        <tr>
            <td>{{ $conta->id }}</td>
            <td>{{ $conta->nome }}</td>
            <td>{{ $conta->tipo }}</td>
            <td>{{ number_format($conta->saldo, 2, ',', '.') }}</td>
            <td>
                <form id="restore-form-{{ $conta->id }}" action="{{ route('admin.conta.restore', $conta->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $conta->id }})">Restaurar</button>

                <form id="purge-form-{{ $conta->id }}" action="{{ route('admin.conta.purge', $conta->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $conta->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta conta?",
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
            text: "Esta ação excluirá permanentemente a conta!",
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