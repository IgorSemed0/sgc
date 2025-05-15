@extends('admin.layouts.body')
@section('title', 'Listar Ocorrências')
@section('conteudo')
    <h1 class="h3">Tabela de Ocorrências</h1>
    
    <div class="card p-4">
        <table class="table table-striped myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Usuário</th>
                    <th>Data de Criação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ocorrencias as $ocorrencia)
                <tr>
                    <td>{{ $ocorrencia->id }}</td>
                    <td>{{ $ocorrencia->descricao }}</td>
                    <td>{{ $ocorrencia->user->full_name }}</td>
                    <td>{{ $ocorrencia->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
@endsection