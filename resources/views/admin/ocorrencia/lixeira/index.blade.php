@extends('admin.layouts.body')
@section('title', 'Lixeira de Us| Usuários')
@section('conteudo')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    <h1 class="h3">Usuários Apagados</h1>
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
                    <form id="restore-form-{{ $user->id }}" action="{{ route('admin.user.restore', $user->id) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $user->id }})">Restaurar</button>

                    <form id="purge-form-{{ $user->id }}" action="{{ route('admin.user.purge', $user->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $user->id }})">Excluir Permanentemente</button>
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
                text: "Deseja restaurar este usuário?",
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
                text: "Esta ação excluirá permanentemente o usuário!",
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