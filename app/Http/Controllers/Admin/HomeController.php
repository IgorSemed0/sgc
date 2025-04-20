<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\User;
use App\Models\Funcionario;
use App\Models\EspacoReserva;
use App\Models\Despesa;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $data['totalUnidades'] = Unidade::count();
        $data['totalMoradores'] = User::where('tipo_usuario', 'morador')->count();
        $data['totalFuncionarios'] = Funcionario::count();
        $data['totalReservas'] = EspacoReserva::where('status', 'ativa')->count();

        $data['unitTypes'] = Unidade::select('tipo', DB::raw('count(*) as total'))
                                    ->groupBy('tipo')
                                    ->pluck('total', 'tipo')
                                    ->toArray();

        $data['reservationsPerMonth'] = EspacoReserva::select(DB::raw('MONTH(data_reserva) as month'), DB::raw('count(*) as total'))
                                                    ->whereYear('data_reserva', date('Y'))
                                                    ->groupBy('month')
                                                    ->orderBy('month')
                                                    ->pluck('total', 'month')
                                                    ->toArray();

        $data['expensesByCategory'] = Despesa::select('categoria', DB::raw('sum(valor) as total'))
                                            ->groupBy('categoria')
                                            ->pluck('total', 'categoria')
                                            ->toArray();

        return view('admin.index', $data);
    }
}