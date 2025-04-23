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
        <!-- <div class="logo">
            <img src="{{ public_path('assets/images/L.png') }}" alt="Logo" height="120px" width="120px">
        </div> -->
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
    function nomeMesPortugues($mesNumero) {
        $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                  7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
        return $meses[(int)$mesNumero] ?? 'Mês Inválido';
    }
    if (!empty($_POST['bi'])) {
        $descricaoFiltros[] = "BI: " . $_POST['bi'];
    }
    if (!empty($_POST['condominio_id'])) {
        $condominio = \App\Models\Condominio::find($_POST['condominio_id']);
        $descricaoFiltros[] = "Condomínio: " . ($condominio ? $condominio->nome : 'Desconhecido');
    }
    if (!empty($_POST['data'])) {
        $data = date('d/m/Y', strtotime($_POST['data']));
        $descricaoFiltros[] = "Data: " . $data;
    }
    if (!empty($_POST['data_inicio']) && !empty($_POST['data_fim'])) {
        $dataInicio = date('d/m/Y', strtotime($_POST['data_inicio']));
        $dataFim = date('d/m/Y', strtotime($_POST['data_fim']));
        $descricaoFiltros[] = "Intervalo de Datas: " . $dataInicio . " a " . $dataFim;
    }
    if (!empty($_POST['mes'])) {
        $mes = nomeMesPortugues($_POST['mes']);
        $descricaoFiltros[] = "Mês: " . $mes;
    }
    if (!empty($_POST['ano'])) {
        $descricaoFiltros[] = "Ano: " . $_POST['ano'];
    }
    if (!empty($_POST['tipo_relatorio'])) {
        $descricaoFiltros[] = "Tipo: " . ucfirst($_POST['tipo_relatorio']);
    }
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
                    <th>Frequência</th>
                </tr>
            </thead>
            <tbody>
                @foreach($frequency as $entidade_id => $count)
                    <tr>
                        <td>{{ optional(\App\Models\Visitante::find($entidade_id))->primeiro_nome . ' ' . optional(\App\Models\Visitante::find($entidade_id))->ultimo_nome ?? '—' }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $total }}</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Visitante</th>
                    <th>BI</th>
                    <th>Data/Hora</th>
                    <th>Motivo da Visita</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acessos as $index => $acesso)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($acesso->visitante)->primeiro_nome . ' ' . optional($acesso->visitante)->ultimo_nome ?? '—' }}</td>
                        <td>{{ optional($acesso->visitante)->bi ?? '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($acesso->data_hora)->format('d/m/Y H:i') }}</td>
                        <td>{{ optional($acesso->visitante)->motivo_visita ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p class="footer">Gerado automaticamente - {{ date('d/m/Y H:i') }}</p>
</body>
</html>