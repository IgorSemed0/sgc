<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Funcionários</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #2C3E50; text-transform: uppercase; letter-spacing: 2px; font-size: 24px; margin-bottom: 10px; text-align: center; }
        h3 { color: #2C3E50; font-size: 18px; margin-top: 20px; text-align: center; }
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
    </style>
</head>
<body>
    <div class="header">
        <div class="insignia">
            <img src="{{ public_path('assets/images/insignia.jpeg') }}" alt="Insígnia" height="60px" width="60px"><br>
            <div class="textos-cabecalho">
                <p>Condominio Integrated Manager Platform</p>
                <p>Relatório de Funcionários</p>
            </div>
        </div>
    </div>
    <hr>

    <h2>Relatório de Funcionários</h2>
    <p>Data de geração: {{ now()->format('d/m/Y') }}</p>
    <p>Período: {{ $periodText }}</p>
    <p>Total de funcionários: {{ $totalFuncionarios }}</p>

    @foreach ($funcionariosPorTipo as $tipo => $funcionariosDoTipo)
        <h3>{{ $tipo }} ({{ $funcionariosDoTipo->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cargo</th>
                    <th>Departamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($funcionariosDoTipo as $funcionario)
                    <tr>
                        <td>{{ $funcionario->primeiro_nome }} {{ $funcionario->ultimo_nome }}</td>
                        <td>{{ $funcionario->email }}</td>
                        <td>{{ $funcionario->telefone }}</td>
                        <td>{{ $funcionario->cargo ?? '-' }}</td>
                        <td>{{ $funcionario->departamento->nome ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <p class="footer">GesCondo - {{ date('d/m/Y H:i') }}</p>
</body>
</html>