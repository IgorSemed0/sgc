@extends('admin.layouts.body')
@section('title', 'Lixeira de Unidades')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.unidade.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Unidades Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Número</th>
            <th>Bloco Sigla</th>
            <th>Edifício Sigla</th>
            <th>Área (m²)</th>
            <th>Andar</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($unidades as $unidade)
        <tr>
            <td>{{ $unidade->id }}</td>
            <td>{{ $unidade->tipo }}</td>
            <td>{{ $unidade->numero }}</td>
            <td>{{ $unidade->bloco->nome }}</td>
            <td>{{ $unidade->edificio->nome }}</td>
            <td>{{ $unidade->area_m2 }}</td>
            <td>{{ $unidade->andar }}</td>
            <td>{{ $unidade->status }}</td>
            <td>
                <form id="restore-form-{{ $unidade->id }}" action="{{ route('admin.unidade.restore', $unidade->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $unidade->id }})">Restaurar</button>

                <form id="purge-form-{{ $unidade->id }}" action="{{ route('admin.unidade.purge', $unidade->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $unidade->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta unidade?",
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
            text: "Esta ação excluirá permanentemente a unidade!",
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