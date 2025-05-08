@extends('admin.layouts.body')
@section('title', 'Lixeira de Moradores')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.morador.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Moradores Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>BI</th>
            <th>Data de Nascimento</th>
            <th>Sexo</th>
            <th>Tipo</th>
            <th>Unidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($moradores as $morador)
        <tr>
            <td>{{ $morador->id }}</td>
            <td>{{ $morador->primeiro_nome }} {{ $morador->nomes_meio }} {{ $morador->ultimo_nome }}</td>
            <td>{{ $morador->email }}</td>
            <td>{{ $morador->telefone }}</td>
            <td>{{ $morador->bi }}</td>
            <td>{{ $morador->data_nascimento }}</td>
            <td>{{ $morador->sexo }}</td>
            <td>{{ $morador->tipo }}</td>
            <td>{{ $morador->unidade->tipo }} - {{ $morador->unidade->numero }}</td>
            <td>
                <form id="restore-form-{{ $morador->id }}" action="{{ route('admin.morador.restore', $morador->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $morador->id }})">Restaurar</button>

                <form id="purge-form-{{ $morador->id }}" action="{{ route('admin.morador.purge', $morador->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $morador->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este morador?",
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
            text: "Esta ação excluirá permanentemente o morador!",
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