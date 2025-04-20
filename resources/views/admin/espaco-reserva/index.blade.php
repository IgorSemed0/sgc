@extends('admin.layouts.body')
@section('title', 'Listar Reservas de Espaço')
@section('conteudo')
<h1 class="h3">Tabela de Reservas de Espaço</h1>
<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#espacoReservaModal">Nova Reserva de Espaço</button>
    <a href="{{ route('admin.espaco-reserva.trash') }}" class="btn btn-secondary">
        <i class="fas fa-trash"></i> Lixeira
    </a>
</div>

<div class="card p-4">
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
                    <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_modal{{ $espacoReserva->id }}">Editar</a>
                    <a class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.espaco-reserva.destroy', $espacoReserva->id) }}')">Deletar</a>
                </td>
            </tr>

            <div class="modal fade" id="editar_modal{{ $espacoReserva->id }}" tabindex="-1" aria-labelledby="editar_modal{{ $espacoReserva->id }}Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Reserva de Espaço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('admin.espaco-reserva.editar.index', ['espacoReserva' => $espacoReserva])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="espacoReservaModal" tabindex="-1" aria-labelledby="espacoReservaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Reserva de Espaço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @include('admin.espaco-reserva.cadastrar.index')
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