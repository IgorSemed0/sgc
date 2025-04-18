@extends('admin.layouts.body')
@section('title', 'Lixeira de Condomínios')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.condominio.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Condomínios Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($condominios as $condominio)
        <tr>
            <td>{{ $condominio->id }}</td>
            <td>{{ $condominio->nome }}</td>
            <td>{{ $condominio->cidade }}</td>
            <td>{{ $condominio->estado }}</td>
            <td>
                <form action="{{ route('admin.condominio.restore', $condominio->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                </form>
                <form action="{{ route('admin.condominio.purge', $condominio->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="confirmPurge('{{ route('admin.condominio.purge', $condominio->id) }}')">Excluir Permanentemente</button>

                </form>
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
    function confirmRestore(url) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja restaurar este condomínio?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, restaurar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function confirmPurge(url) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação excluirá permanentemente o condomínio!",
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