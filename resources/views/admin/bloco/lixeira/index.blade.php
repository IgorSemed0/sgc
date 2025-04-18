@extends('admin.layouts.body')
@section('title', 'Lixeira de Blocos')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.bloco.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Blocos Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Condomínio</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($blocos as $bloco)
        <tr>
            <td>{{ $bloco->id }}</td>
            <td>{{ $bloco->nome }}</td>
            <td>{{ $bloco->descricao }}</td>
            <td>{{ $bloco->condominio->nome }}</td>
            <td>
                <button class="btn btn-success btn-sm" onclick="confirmRestore('{{ route('admin.bloco.restore', $bloco->id) }}')">Restaurar</button>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge('{{ route('admin.bloco.purge', $bloco->id) }}')">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este bloco?",
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
            text: "Esta ação excluirá permanentemente o bloco!",
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