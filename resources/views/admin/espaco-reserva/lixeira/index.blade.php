@extends('admin.layouts.body')
@section('title', 'Lixeira de Reservas de Espaço')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.espaco-reserva.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Reservas de Espaço Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Espaço Comum</th>
            <th>Usuário</th>
            <th>Data Reserva</th>
            <th>Hora Início</th>
            <th>Hora Fim</th>
            <th>Status</th>
            <th>Observação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($espacoReservas as $espacoReserva)
        <tr>
            <td>{{ $espacoReserva->id }}</td>
            <td>{{ $espacoReserva->espacoComum->nome }}</td>
            <td>{{ $espacoReserva->user->full_name }}</td>
            <td>{{ \Carbon\Carbon::parse($espacoReserva->data_reserva)->format('d/m/Y') }}</td>
            <td>{{ $espacoReserva->hora_inicio }}</td>
            <td>{{ $espacoReserva->hora_fim }}</td>
            <td>{{ $espacoReserva->status }}</td>
            <td>{{ $espacoReserva->observacao ?? '-' }}</td>
            <td>
                <form id="restore-form-{{ $espacoReserva->id }}" action="{{ route('admin.espaco-reserva.restore', $espacoReserva->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $espacoReserva->id }})">Restaurar</button>

                <form id="purge-form-{{ $espacoReserva->id }}" action="{{ route('admin.espaco-reserva.purge', $espacoReserva->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $espacoReserva->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta reserva de espaço?",
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
            text: "Esta ação excluirá permanentemente a reserva de espaço!",
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