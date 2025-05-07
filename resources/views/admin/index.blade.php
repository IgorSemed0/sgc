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
    <!-- Multi-line Chart: Full Width -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">Finanças por Mês</div>
                <div class="card-body" style="width: 100%; height: auto;">
                    <canvas id="graficoLinha"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar Chart (Left) and Pie Chart (Right) -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Unidades por Tipo</div>
                <div class="card-body" style="display: flex; justify-content: center; align-items: center; height: 400px;">
                    <!-- Set explicit width and height for the canvas -->
                    <canvas id="graficoBarras" style="max-width: 100%; max-height: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Moradores por Tipo</div>
                <div class="card-body" style="display: flex; justify-content: center; align-items: center; height: 400px;">
                    <!-- Set explicit width and height for the canvas -->
                    <canvas id="graficoPizza" style="max-width: 100%; max-height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Multi-line Chart: Revenues, Expenses, Balance
            const ctxLinha = document.getElementById("graficoLinha").getContext("2d");
            new Chart(ctxLinha, {
                type: "line",
                data: {
                    labels: @json($months),
                    datasets: [
                        {
                            label: "Receitas",
                            data: @json($revenuesPerMonth),
                            borderColor: "#28a745",
                            fill: false
                        },
                        {
                            label: "Despesas",
                            data: @json($expensesPerMonth),
                            borderColor: "#dc3545",
                            fill: false
                        },
                        {
                            label: "Saldo",
                            data: @json($balancePerMonth),
                            borderColor: "#007bff",
                            fill: false
                        }
                    ]
                }
            });

            // Bar Chart: Units per Type
            const ctxBarras = document.getElementById("graficoBarras").getContext("2d");
            new Chart(ctxBarras, {
                type: "bar",
                data: {
                    labels: @json(array_keys($unitTypes)),
                    datasets: [{
                        label: "Número de Unidades",
                        data: @json(array_values($unitTypes)),
                        backgroundColor: "#ffc107"
                    }]
                }
            });

            // Pie Chart: Residents per Type
            const ctxPizza = document.getElementById("graficoPizza").getContext("2d");
            new Chart(ctxPizza, {
                type: "pie",
                data: {
                    labels: @json(array_keys($residentTypes)),
                    datasets: [{
                        data: @json(array_values($residentTypes)),
                        backgroundColor: ["#007bff", "#28a745", "#ffc107"]
                    }]
                }
            });
        });
    </script>
@endsection