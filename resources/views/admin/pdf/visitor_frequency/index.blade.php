<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Frequência de Visitantes</title>
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
        .logo { position: absolute; left: 0; }
        .insignia { position: absolute; left: 50%; transform: translateX(-50%); text-align: center; }
        .textos-cabecalho p { margin: 2px 0; line-height: 1.2; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('assets/images/L.png') }}" alt="Logo" height="120px" width="120px">
        </div>
        <div class="insignia">
            <img src="{{ public_path('assets/images/insignia.jpeg') }}" alt="Insígnia" height="60px" width="60px"><br>
            <div class="textos-cabecalho">
                <p>Condominio Integrated Manager Platform</p>
                <p>Relatório de Frequência de Visitantes</p>
            </div>
        </div>
    </div>
    <hr>

    <h2>Relatório de Frequência de Visitantes</h2>

    <?php
    $descricaoFiltros = [];
    if (!empty($_POST['bi'])) $descricaoFiltros[] = "BI: " . $_POST['bi'];
    if (!empty($_POST['condominio_id'])) {
        $condominio = \App\Models\Condominio::find($_POST['condominio_id']);
        $descricaoFiltros[] = "Condomínio: " . ($condominio ? $condominio->nome : 'Desconhecido');
    }
    if (!empty($_POST['data'])) $descricaoFiltros[] = "Data: " . $_POST['data'];
    if (!empty($_POST['data_inicio']) && !empty($_POST['data_fim'])) $descricaoFiltros[] = "Período: " . $_POST['data_inicio'] . " a " . $_POST['data_fim'];
    if (!empty($_POST['mes']) && !empty($_POST['ano'])) $descricaoFiltros[] = "Mês/Ano: " . $_POST['mes'] . "/" . $_POST['ano'];
    $descricaoFiltros[] = "Tipo: " . $tipo_relatorio;
    ?>

    @if(!empty($descricaoFiltros))
        <p><strong>Filtros aplicados:</strong> {{ implode("; ", $descricaoFiltros) }}.</p>
    @else
        <p><strong>Nota:</strong> Nenhum filtro aplicado. Exibindo todos os registros.</p>
    @endif

    @if($tipo_relatorio == 'quantitativo')
        <table>
            <thead>
                <tr>
                    <th>Visitante</th>
                    <th>Quantidade de Acessos</th>
                    <th>Percentual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($frequency as $entidade_id => $count)
                    <?php $pessoa = \App\Models\Visitante::find($entidade_id); ?>
                    <tr>
                        <td>{{ $pessoa ? trim($pessoa->primeiro_nome . ' ' . ($pessoa->nomes_meio ?? '') . ' ' . $pessoa->ultimo_nome) : 'Desconhecido' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $total ? round(($count / $total) * 100, 2) : 0 }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>BI</th>
                    <th>Data/Hora</th>
                    <th>Unidade Visitada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acessos as $acesso)
                    <tr>
                        <td>{{ $acesso->nome_completo }}</td>
                        <td>{{ $acesso->pessoa->bi ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($acesso->data_hora)->format('d/m/Y H:i') }}</td>
                        <td>{{ $acesso->pessoa->unidade->numero ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p class="footer">Gerado automaticamente - {{ date('d/m/Y H:i') }}</p>
</body>
</html>