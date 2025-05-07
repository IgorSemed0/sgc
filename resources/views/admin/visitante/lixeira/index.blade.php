@extends('admin.layouts.body')
@section('title', 'Lixeira de Visitantes')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.visitante.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Visitantes Apagados</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>BI</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Motivo da Visita</th>
            <th>Data Entrada</th>
            <th>Data Saída</th>
            <th>Unidade</th>
            <th>Condomínio</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($visitantes as $visitante)
        <tr>
            <td>{{ $visitante->id }}</td>
            <td>{{ $visitante->primeiro_nome }} {{ $visitante->nomes_meio }} {{ $visitante->ultimo_nome }}</td>
            <td>{{ $visitante->bi }}</td>
            <td>{{ $visitante->email }}</td>
            <td>{{ $visitante->telefone }}</td>
            <td>{{ $visitante->motivo_visita }}</td>
            <td>{{ $visitante->data_entrada }}</td>
            <td>{{ $visitante->data_saida }}</td>
            <td>{{ $visitante->unidade->tipo }} - {{ $visitante->unidade->numero }}</td>
            <td>
                <form id="restore-form-{{ $visitante->id }}" action="{{ route('admin.visitante.restore', $visitante->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $visitante->id }})">Restaurar</button>

                <form id="purge-form-{{ $visitante->id }}" action="{{ route('admin.visitante.purge', $visitante->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $visitante->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar este visitante?",
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
            text: "Esta ação excluirá permanentemente o visitante!",
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