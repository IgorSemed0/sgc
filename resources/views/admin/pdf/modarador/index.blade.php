@include('admin.pdf._header')

<h1>Relatório de Moradores</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total de moradores: {{ $totalMoradores }}</p>

@foreach ($moradoresPorTipo as $tipo => $moradoresDoTipo)
    <h2>{{ $tipo }} ({{ $moradoresDoTipo->count() }})</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Unidade</th>
                <th>Email</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($moradoresDoTipo as $morador)
                <tr>
                    <td>{{ $morador->primeiro_nome }} {{ $morador->ultimo_nome }}</td>
                    <td>{{ $morador->unidade->numero }}</td>
                    <td>{{ $morador->email }}</td>
                    <td>{{ $morador->telefone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach