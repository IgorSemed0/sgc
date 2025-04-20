@extends('admin.layouts.body')
@section('title', 'Lixeira de Votos')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.voto.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Votos Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Votação</th>
            <th>Usuário</th>
            <th>Opção</th>
            <th>Data/Hora</th>
            <th>Hash Voto</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($votos as $voto)
        <tr>
            <td>{{ $voto->id }}</td>
            <td>{{ $voto->votacao->titulo }}</td>
            <td>{{ $voto->user->full_name }}</td>
            <td>{{ $voto->opcaoVotacao->descricao }}</td>
            <td>{{ \Carbon\Carbon::parse($voto->data_hora)->format('d/m/Y H:i') }}</td>
            <td>{{ $voto->hash_voto ?? '-' }}</td>
            <td>
                <form id="restore-form-{{ $voto->id }}" action="{{ route('admin.voto.restore', $voto->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $voto->id }})">Restaurar</button>

                <form id="purge-form-{{ $voto->id }}" action="{{ route('admin.voto.purge', $voto->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $voto->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este voto?",
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
            text: "Esta ação excluirá permanentemente o voto!",
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