@include('admin.pdf._header')

<h1>Relatório de Inadimplência</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total inadimplente: {{ number_format($totalInadimplencia, 2, ',', '.') }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Unidade</th>
            <th>Referência</th>
            <th>Data Vencimento</th>
            <th>Valor Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($facturas as $factura)
            <tr>
                <td>{{ $factura->unidade->numero }}</td>
                <td>{{ $factura->referencia }}</td>
                <td>{{ $factura->data_vencimento->format('d/m/Y') }}</td>
                <td>{{ number_format($factura->valor_total, 2, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>