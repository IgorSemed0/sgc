@include('admin.pdf._header')

<h1>Relatório de Despesas</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total de despesas: {{ number_format($totalDespesas, 2, ',', '.') }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($despesas as $despesa)
            <tr>
                <td>{{ $despesa->descricao }}</td>
                <td>{{ number_format($despesa->valor, 2, ',', '.') }}</td>
                <td>{{ $despesa->data_despesa->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>