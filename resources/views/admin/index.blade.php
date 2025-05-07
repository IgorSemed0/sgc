@extends('admin.layouts.body')

@section('conteudo')
    <h1 class="h3">Bem-vindo ao Painel</h1>

    <!-- Totals Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-header">Total de Unidades</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ $totalUnidades }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-header">Total de Moradores</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ $totalMoradores }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-header">Saldo Atual</div>
                    <div class="card-body">
                        <h5 class="card-title mt-4 mb-4">{{ number_format($saldoAtual, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-header">Inadimplência</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ number_format($inadimplencia, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Pie Chart: Unit Types Distribution -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Distribuição de Tipos de Unidades</div>
                <div class="card-body">
                    <canvas id="graficoPizza"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart: Totals Comparison -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Comparação de Totais</div>
                <div class="card-body">
                    <canvas id="graficoBarras"></canvas>
                </div>
            </div>
        </div>

        <!-- Line Chart: Reservations Evolution -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Evolução das Reservas por Mês</div>
                <div class="card-body">
                    <canvas id="graficoLinha"></canvas>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart: Expenses Distribution -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Distribuição de Despesas por Categoria</div>
                <div class="card-body">
                    <canvas id="graficoDoughnut"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Financial Data Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-header">Inadimplência</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ number_format($inadimplencia, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-header">Despesas</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ number_format($despesas, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-header">Receitas</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ number_format($receitas, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-header">Saldo Atual</div>
                <div class="card-body">
                    <h5 class="card-title mt-4 mb-4">{{ number_format($saldoAtual, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Inclusion and Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Pie Chart: Unit Types Distribution
            const ctxPizza = document.getElementById("graficoPizza").getContext("2d");
            new Chart(ctxPizza, {
                type: "pie",
                data: {
                    labels: @json(array_keys($unitTypes)),
                    datasets: [{
                        data: @json(array_values($unitTypes)),
                        backgroundColor: ["#007bff", "#28a745", "#ffc107", "#dc3545", "#17a2b8"]
                    }]
                }
            });

            // Bar Chart: Totals Comparison
            const ctxBarras = document.getElementById("graficoBarras").getContext("2d");
            new Chart(ctxBarras, {
                type: "bar",
                data: {
                    labels: ["Unidades", "Moradores", "Funcionários", "Reservas Ativas"],
                    datasets: [{
                        label: "Total",
                        data: [{{ $totalUnidades }}, {{ $totalMoradores }}, {{ $totalFuncionarios }}, {{ $totalReservas }}],
                        backgroundColor: ["#007bff", "#28a745", "#ffc107", "#dc3545"]
                    }]
                }
            });

            // Line Chart: Reservations per Month
            const months = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
            const reservationsData = @json($reservationsPerMonth);
            const reservationsPerMonth = Array(12).fill(0);
            for (const [month, total] of Object.entries(reservationsData)) {
                reservationsPerMonth[month - 1] = total;
            }
            const ctxLinha = document.getElementById("graficoLinha").getContext("2d");
            new Chart(ctxLinha, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                        label: "Reservas",
                        data: reservationsPerMonth,
                        borderColor: "#ffc107",
                        fill: false
                    }]
                }
            });

            // Doughnut Chart: Expenses by Category
            const ctxDoughnut = document.getElementById("graficoDoughnut").getContext("2d");
            new Chart(ctxDoughnut, {
                type: "doughnut",
                data: {
                    labels: @json(array_keys($expensesByCategory)),
                    datasets: [{
                        data: @json(array_values($expensesByCategory)),
                        backgroundColor: ["#dc3545", "#ffc107", "#17a2b8", "#28a745", "#007bff"]
                    }]
                }
            });
        });
    </script>
@endsection