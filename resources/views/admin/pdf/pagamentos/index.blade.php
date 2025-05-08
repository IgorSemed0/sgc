@include('admin.pdf._header')

<h1>Relatório de Pagamentos</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total pago: {{ number_format($totalPagamentos, 2, ',', '.') }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Referência Fatura</th>
            <th>Data Pagamento</th>
            <th>Valor Pago</th>
            <th>Método</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagamentos as $pagamento)
            <tr>
                <td>{{ $pagamento->factura->referencia }}</td>
                <td>{{ $pagamento->data_pagamento->format('d/m/Y') }}</td>
                <td>{{ number_format($pagamento->valor_pago, 2, ',', '.') }}</td>
                <td>{{ $pagamento->metodo_pagamento }}</td>
            </tr>
        @endforeach
    </tbody>
</table>