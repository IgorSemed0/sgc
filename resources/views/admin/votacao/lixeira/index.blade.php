@extends('admin.layouts.body')
@section('title', 'Lixeira de Votações')
@section('conteudo')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.votacao.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>
<h1 class="h3">Votações Apagadas</h1>
<table class="table table-striped myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Condomínio</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Data Início</th>
            <th>Data Fim</th>
            <th>Quórum Mínimo</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($votacaos as $votacao)
        <tr>
            <td>{{ $votacao->id }}</td>
            <td>{{ $votacao->titulo }}</td>
            <td>{{ $votacao->descricao }}</td>
            <td>{{ \Carbon\Carbon::parse($votacao->data_inicio)->format('d/m/Y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($votacao->data_fim)->format('d/m/Y H:i') }}</td>
            <td>{{ $votacao->quorum_minimo ?? '-' }}</td>
            <td>{{ $votacao->status }}</td>
            <td>
                <form id="restore-form-{{ $votacao->id }}" action="{{ route('admin.votacao.restore', $votacao->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-success btn-sm" onclick="confirmRestore({{ $votacao->id }})">Restaurar</button>

                <form id="purge-form-{{ $votacao->id }}" action="{{ route('admin.votacao.purge', $votacao->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                <button class="btn btn-danger btn-sm" onclick="confirmPurge({{ $votacao->id }})">Excluir Permanentemente</button>
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
            text: "Deseja restaurar esta votação?",
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
            text: "Esta ação excluirá permanentemente a votação!",
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