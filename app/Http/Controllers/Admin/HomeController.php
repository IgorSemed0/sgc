<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\Morador;
use App\Models\Pagamento;
use App\Models\Despesa;
use App\Models\Factura;
use App\Models\Conta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Stat boxes data
        $data['totalUnidades'] = Unidade::count();
        $data['totalMoradores'] = Morador::count();
        $data['saldoAtual'] = Conta::find(1)->saldo;
        $data['inadimplencia'] = Factura::where('status', 'Pendente')->sum('valor_total');

        // Multi-line chart data: revenues, expenses, and balance per month
        $year = date('Y');
        $months = range(1, 12);
        $revenuesPerMonth = [];
        $expensesPerMonth = [];
        $balancePerMonth = [];

        foreach ($months as $month) {
            $revenuesPerMonth[$month] = Pagamento::whereYear('data_pagamento', $year)
                ->whereMonth('data_pagamento', $month)
                ->sum('valor_pago');
            $expensesPerMonth[$month] = Despesa::whereYear('data_despesa', $year)
                ->whereMonth('data_despesa', $month)
                ->sum('valor');
            $lastDay = Carbon::create($year, $month, 1)->endOfMonth();
            $cumulativeRevenues = Pagamento::where('data_pagamento', '<=', $lastDay)->sum('valor_pago');
            $cumulativeExpenses = Despesa::where('data_despesa', '<=', $lastDay)->sum('valor');
            $balancePerMonth[$month] = $cumulativeRevenues - $cumulativeExpenses;
        }

        $data['revenuesPerMonth'] = array_values($revenuesPerMonth);
        $data['expensesPerMonth'] = array_values($expensesPerMonth);
        $data['balancePerMonth'] = array_values($balancePerMonth);
        $data['months'] = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        // Bar chart data: units per type
        $data['unitTypes'] = Unidade::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->pluck('total', 'tipo')
            ->toArray();

        // Pie chart data: residents per type
        $data['residentTypes'] = Morador::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->pluck('total', 'tipo')
            ->toArray();

        return view('admin.index', $data);
    }
}