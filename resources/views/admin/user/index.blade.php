@extends('admin.layouts.body')
@section('title', 'Listar Usuários')
@section('conteudo')
    <h1 class="h3">Tabela de Usuários</h1>
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Novo Usuário</button>
        <a href="{{ route('admin.user.trash') }}" class="btn btn-secondary">
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
                    <th>Username</th>
                    <th>BI</th>
                    <th>Telefone</th>
                    <th>Tipo</th>
                        <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->bi }}</td>
                    <td>{{ $user->telefone ?? '-' }}</td>
                    <td>{{ $user->tipo_usuario }}</td>
                    <td>
                        <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $user->id }}">Editar</a>
                        <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.user.destroy', $user->id) }}')">Deletar</a>
                    </td>
                </tr>

                <div class="modal fade" id="editar_modal{{ $user->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $user->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Usuário</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @include('admin.user.editar.index', ['user' => $user])
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastro de Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @include('admin.user.cadastrar.index')
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