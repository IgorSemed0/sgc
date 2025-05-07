```php
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Ocupação de Unidades</title>
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
                <p>Relatório de Ocupação de Unidades</p>
            </div>
        </div>
    </div>
    <hr>

    <h2>Relatório de Ocupação de Unidades</h2>

    <?php
    $descricaoFiltros = [];
    if (!empty($_POST['condominio_id'])) {
        $condominio = \App\Models\Condominio::find($_POST['condominio_id']);
        $descricaoFiltros[] = "Condomínio: " . ($condominio ? $condominio->nome : 'Desconhecido');
    }
    if (!empty($_POST['bloco'])) {
        $descricaoFiltros[] = "Bloco: " . $_POST['bloco'];
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
                    <th>Status</th>
                    <th>Quantidade</th>
                    <th>Percentual</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ocupadas</td>
                    <td>{{ $occupied }}</td>
                    <td>{{ $total ? round(($occupied / $total) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Vagas</td>
                    <td>{{ $vacant }}</td>
                    <td>{{ $total ? round(($vacant / $total) * 100, 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $total }}</strong></td>
                    <td><strong>100%</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                        <th>Bloco</th>
                    <th>Número</th>
                    <th>Status</th>
                    <th>Morador</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unidades as $index => $unidade)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($unidade->condominio)->nome ?? '—' }}</td>
                        <td>{{ $unidade->bloco }}</td>
                        <td>{{ $unidade->numero }}</td>
                        <td>{{ $unidade->morador_id ? 'Ocupada' : 'Vaga' }}</td>
                        <td>{{ optional($unidade->morador)->primeiro_nome . ' ' . optional($unidade->morador)->ultimo_nome ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p class="footer">Gerado automaticamente - {{ date('d/m/Y H:i') }}</p>
</body>
</html>
```