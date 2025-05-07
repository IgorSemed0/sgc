@extends('admin.layouts.body')
@section('title', 'Listar Funcionários')
@section('conteudo')
<h1 class="h3">Tabela de Funcionários</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#funcionarioModal">Novo Funcionário</button>
    <a href="{{ route('admin.funcionario.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
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
                <td>
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $funcionario->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.funcionario.destroy', $funcionario->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $funcionario->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $funcionario->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Funcionário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.funcionario.editar.index', ['funcionario' => $funcionario])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="funcionarioModal" tabindex="-1" aria-labelledby="funcionarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.funcionario.cadastrar.index')
            </div>
        </div>
    </div>
</div>

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
    function confirmDelete(url) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação não pode ser desfeita!",
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