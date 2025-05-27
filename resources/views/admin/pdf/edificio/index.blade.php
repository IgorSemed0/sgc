<!-- resources/views/admin/pdf/edificio/index.blade.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Edifícios</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #2C3E50; text-transform: uppercase; letter-spacing: 2px; font-size: 24px; margin-bottom: 10px; text-align: center; }
        hr { border: 1px solid #2C3E50; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; text-align: center; }
        th, td { border: 1px solid #2C3E50; padding: 10px; text-align: center; }
        th { background-color: #34495E; color: white; }
        tr:nth-child(even) { background-color: #ECF0F1; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; text-align: center; }
        p { text-align: center; }
    </style>
</head>
<body>
    <h2>Relatório de Edifícios</h2>
    <p>Data de geração: {{ now()->format('d/m/Y') }}</p>
    <p>Período: {{ $periodText }}</p>
    <p>Total de edifícios: {{ $totalEdificios }}</p>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Bloco</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($edificios as $edificio)
                <tr>
                    <td>{{ $edificio->nome }}</td>
                    <td>{{ $edificio->descricao }}</td>
                    <td>{{ $edificio->bloco->nome ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="footer">ConGest - {{ date('d/m/Y H:i') }}</p>
</body>
</html>