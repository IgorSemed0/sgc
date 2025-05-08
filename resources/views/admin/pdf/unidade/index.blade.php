@include('admin.pdf._header')

<h1>Relatório de Unidades por Bloco</h1>
<p>Data de geração: {{ now()->format('d/m/Y') }}</p>
<p>Total de unidades: {{ $totalUnidades }}</p>

@foreach ($blocos as $bloco)
    <h2>Bloco: {{ $bloco->nome }} ({{ $bloco->unidade->count() }})</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Número</th>
                <th>Andar</th>
                <th>Área (m²)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bloco->unidade as $unidade)
                <tr>
                    <td>{{ $unidade->tipo }}</td>
                    <td>{{ $unidade->numero }}</td>
                    <td>{{ $unidade->andar }}</td>
                    <td>{{ $unidade->area_m2 }}</td>
                    <td>{{ $unidade->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach