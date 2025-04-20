@extends('admin.layouts.body')
@section('title', 'Lixeira de Funcionários')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.funcionario.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Funcionários Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>BI</th>
            <th>Sexo</th>
            <th>Cargo</th>
            <th>Departamento</th>
            <th>Condomínio</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($funcionarios as $funcionario)
        <tr>
            <td>{{ $funcionario->id }}</td>
            <td>{{ $funcionario->primeiro_nome }} {{ $funcionario->nomes_meio }} {{ $funcionario->ultimo_nome }}</td>
            <td>{{ $funcionario->email }}</td>
            <td>{{ $funcionario->telefone }}</td>
            <td>{{ $funcionario->bi }}</td>
            <td>{{ $funcionario->sexo }}</td>
            <td>{{ $funcionario->cargo }}</td>
            <td>{{ $funcionario->departamento->nome }}</td>
            <td>{{ $funcionario->condominio->nome }}</td>
            <td>
                <form id="restore-form-{{ $funcionario->id }}" action="{{ route('admin.funcionario.restore', $funcionario->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $funcionario->id }})">Restaurar</button>

                <form id="purge-form-{{ $funcionario->id }}" action="{{ route('admin.funcionario.purge', $funcionario->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $funcionario->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este funcionário?",
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
            text: "Esta ação excluirá permanentemente o funcionário!",
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