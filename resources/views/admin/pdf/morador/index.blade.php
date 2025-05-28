<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Moradores</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #2C3E50; text-transform: uppercase; letter-spacing: 2px; font-size: 24px; margin-bottom: 10px; text-align: center; }
        h3 { color: #2C3E50; font-size: 18px; margin-top: 20px; text-align: center; }
        hr { border: 1px solid #2C3E50; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; text-align: center; }
        th, td { border: 1px solid #2C3E50; padding: 8px; text-align: center; font-size: 12px; }
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
                <p>ConGest</p>
                <p>Relatório de Moradores</p>
            </div>
        </div>
    </div>
    <hr>

    <h2>Relatório de Moradores</h2>
    <p>Data de geração: {{ now()->format('d/m/Y') }}</p>
    <p>Período: {{ $periodText }}</p>
    <p>Total de moradores: {{ $totalMoradores }}</p>

    @foreach ($moradoresPorTipo as $tipo => $moradoresDoTipo)
        <h3>{{ ucfirst($tipo) }} ({{ $moradoresDoTipo->count() }})</h3>
        
        @if($tipo === 'dependente')
            {{-- Table for dependentes with specific columns --}}
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th>Imóvel</th>
                        <th>Morador Associado</th>
                        <th>Grau Parentesco</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moradoresDoTipo as $morador)
                        <tr>
                            <td>{{ $morador->primeiro_nome }} {{ $morador->ultimo_nome }}</td>
                            <td>{{ $morador->sexo ?? 'N/A' }}</td>
                            <td>{{ $morador->idade ?? 'N/A' }}</td>
                            <td>{{ $morador->unidade->numero ?? 'N/A' }}</td>
                            <td>{{ $morador->nome_morador_associado ?? 'N/A' }}</td>
                            <td>{{ $morador->grau_parentesco ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- Table for proprietario and inquilino with standard columns --}}
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th>Imóvel</th>
                        <th>Email</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moradoresDoTipo as $morador)
                        <tr>
                            <td>{{ $morador->primeiro_nome }} {{ $morador->ultimo_nome }}</td>
                            <td>{{ $morador->sexo ?? 'N/A' }}</td>
                            <td>{{ $morador->idade ?? 'N/A' }}</td>
                            <td>{{ $morador->unidade->numero ?? 'N/A' }}</td>
                            <td>{{ $morador->email ?? 'N/A' }}</td>
                            <td>{{ $morador->telefone ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    <p class="footer">ConGest - {{ date('d/m/Y H:i') }}</p>
</body>
</html>