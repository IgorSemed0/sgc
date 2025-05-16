<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Inadimplência</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #2C3E50; text-transform: uppercase; letter-spacing: 2px; font-size: 24px; margin-bottom: 10px; text-align: center; }
        hr { border: 1px solid #2C3E50; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; text-align: center; }
        th, td { border: 1px solid #2C3E50; padding: 10px; text-align: center; }
        th { background-color: #34495E; color: white; }
        tr:nth-child(even) { background-color: #ECF0F1; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; text-align: center; }
        p { text-align: center; }
        .header { width: 100%; position: relative; margin-bottom: 20px; }
        .insignia { position: absolute; left: 50%; transform: translateX(-50%); text-align: center; }
        .textos-cabecalho p { margin: 2px 0; line-height: 1.2; font-size: 14px; }
        .period-info { font-size: 16px; font-weight: bold; margin: 10px 0; text-align: center; color: #2C3E50; }
    </style>
</head>
<body>
    <div class="header">
        <div class="insignia">
            <img src="{{ public_path('assets/images/insignia.jpeg') }}" alt="Insígnia" height="60px" width="60px"><br>
            <div class="textos-cabecalho">
                <p>Condominio Integrated Manager Platform</p>
                <p>Relatório de Inadimplência</p>
            </div>
        </div>
    </div>
    <hr>

    <h2>Relatório de Inadimplência</h2>
    <p>Data de geração: {{ now()->format('d/m/Y') }}</p>
    <p class="period-info">{{ $reportDate }}</p>
    <p>Total inadimplente: {{ number_format($totalInadimplencia, 2, ',', '.') }}</p>

    <table>
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

    <p class="footer">GesCondo - {{ date('d/m/Y H:i') }}</p>
</body>
</html>