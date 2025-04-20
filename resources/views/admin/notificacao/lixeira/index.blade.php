@extends('admin.layouts.body')
@section('title', 'Lixeira de Notificações')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.notificacao.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Notificações Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Tipo</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Data/Hora</th>
            <th>Lida</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($notificacaos as $notificacao)
        <tr>
            <td>{{ $notificacao->id }}</td>
            <td>{{ $notificacao->user->full_name }}</td>
            <th>{{ $notificacao->tipo }}</th>
            <td>{{ $notificacao->titulo }}</td>
            <td>{{ Str::limit($notificacao->conteudo, 50) }}</td>
            <td>{{ \Carbon\Carbon::parse($notificacao->data_hora)->format('d/m/Y H:i') }}</td>
            <td>{{ $notificacao->lida ? 'Sim' : 'Não' }}</td>
            <td>
                <form id="restore-form-{{ $notificacao->id }}" action="{{ route('admin.notificacao.restore', $notificacao->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $notificacao->id }})">Restaurar</button>

                <form id="purge-form-{{ $notificacao->id }}" action="{{ route('admin.notificacao.purge', $notificacao->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $notificacao->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta notificação?",
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
            text: "Esta ação excluirá permanentemente a notificação!",
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