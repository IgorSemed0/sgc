@include('admin.pdf._header')

<h1>Relatório de Visitantes</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total de visitantes: {{ $totalVisitantes }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Unidade</th>
            <th>Motivo Visita</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($visitantes as $visitante)
            <tr>
                <td>{{ $visitante->primeiro_nome }} {{ $visitante->ultimo_nome }}</td>
                <td>{{ $visitante->unidade->numero }}</td>
                <td>{{ $visitante->motivo_visita }}</td>
                <td>{{ $visitante->telefone }}</td>
            </tr>
        @endforeach
    </tbody>
</table>