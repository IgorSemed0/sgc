@extends('publico.layouts.body')
@section('title', 'Minhas Ocorrências')
@section('conteudo')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Minhas Ocorrências</h1>
        <a href="{{ route('morador.ocorrencia.create') }}" class="btn btn-primary">Nova Ocorrência</a>
    </div>

    @if(count($ocorrencias) > 0)
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ocorrencias as $ocorrencia)
                        <tr>
                            <td>{{ $ocorrencia->id }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($ocorrencia->descricao, 50) }}</td>
                            <td>{{ $ocorrencia->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('morador.ocorrencia.edit', $ocorrencia->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <a href="#" onclick="confirmDelete('{{ route('morador.ocorrencia.destroy', $ocorrencia->id) }}')" class="btn btn-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        Você ainda não registrou nenhuma ocorrência. Clique em "Nova Ocorrência" para criar um registro.
    </div>
    @endif
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