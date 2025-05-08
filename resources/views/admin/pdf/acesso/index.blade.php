@include('admin.pdf._header')

<h1>Relatório de Acessos</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total de acessos: {{ $totalAcessos }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Tipo Pessoa</th>
            <th>Data/Hora</th>
            <th>Tipo Acesso</th>
            <th>Observação</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($acessos as $acesso)
            <tr>
                <td>{{ $acesso->nome_completo }}</td>
                <td>{{ $acesso->tipo_pessoa }}</td>
                <td>{{ $acesso->data_hora->format('d/m/Y H:i') }}</td>
                <td>{{ $acesso->tipo }}</td>
                <td>{{ $acesso->observacao }}</td>
            </tr>
        @endforeach
    </tbody>
</table>