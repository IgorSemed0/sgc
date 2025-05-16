<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\Acesso;
use App\Models\Visitante;
use App\Models\Morador;
use App\Models\Funcionario;
use App\Models\Condominio;
use App\Models\Bloco;
use App\Models\Despesa;
use App\Models\Factura;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class PdfController extends Controller
{
    public function index()
    {
        return view('admin.pdf.index');
    }

    private function configureMpdf()
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9,
        ]);
        $mpdf->SetTitle('Sistema de Gestão de Condomínios');
        return $mpdf;
    }

    /**
     * Apply date filter to a query based on request parameters
     */
    private function applyDateFilter($query, Request $request, $dateField)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::parse($request->query('start'));
            $end = Carbon::parse($request->query('end'));
            $query->whereBetween($dateField, [$start, $end]);
        } elseif ($request->has('period') && $request->query('period') !== 'all') {
            $period = $request->query('period');
            if ($period === 'week') {
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $query->whereBetween($dateField, [$start, $end]);
            } elseif ($period === 'month') {
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $query->whereBetween($dateField, [$start, $end]);
            } elseif ($period === 'year') {
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $query->whereBetween($dateField, [$start, $end]);
            }
        }
        // If 'all' or no period specified, no filter is applied
    }

    /**
     * Generate text describing the selected period
     */
    private function getPeriodText(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::parse($request->query('start'));
            $end = Carbon::parse($request->query('end'));
            return 'De ' . $start->format('d/m/Y') . ' a ' . $end->format('d/m/Y');
        } elseif ($request->has('period') && $request->query('period') !== 'all') {
            $period = $request->query('period');
            if ($period === 'week') {
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                return 'Última Semana: ' . $start->format('d/m/Y') . ' a ' . $end->format('d/m/Y');
            } elseif ($period === 'month') {
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                return 'Último Mês: ' . $start->format('d/m/Y') . ' a ' . $end->format('d/m/Y');
            } elseif ($period === 'year') {
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                return 'Último Ano: ' . $start->format('d/m/Y') . ' a ' . $end->format('d/m/Y');
            }
        }
        return 'Todos os Períodos';
    }

    public function morador(Request $request)
    {
        $moradores = Morador::with('unidade')->get();
        $moradoresPorTipo = $moradores->groupBy('tipo');
        $totalMoradores = $moradores->count();
        $periodText = $this->getPeriodText($request); // Included for consistency, though no filter applied
        $html = View::make('admin.pdf.morador.index', compact('moradores', 'moradoresPorTipo', 'totalMoradores', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_moradores.pdf', 'I');
    }

    public function unidade(Request $request)
    {
        $blocos = Bloco::with('unidade')->get();
        $totalUnidades = Unidade::count();
        $periodText = $this->getPeriodText($request); // Included for consistency, though no filter applied
        $html = View::make('admin.pdf.unidade.index', compact('blocos', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_unidades.pdf', 'I');
    }

    public function acesso(Request $request)
    {
        $query = Acesso::with(['pessoa' => function($query) {
            return $query;
        }]);
        $this->applyDateFilter($query, $request, 'data_hora');
        $acessos = $query->get();
        $totalAcessos = $acessos->count();
        $periodText = $this->getPeriodText($request);
        $html = View::make('admin.pdf.acesso.index', compact('acessos', 'totalAcessos', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_acessos.pdf', 'I');
    }

    public function despesa(Request $request)
    {
        $query = Despesa::query();
        $this->applyDateFilter($query, $request, 'data_despesa'); // Changed 'data' to 'data_despesa'
        $despesas = $query->get();
        $totalDespesas = $despesas->sum('valor');
        $periodText = $this->getPeriodText($request);
        $html = View::make('admin.pdf.despesa.index', compact('despesas', 'totalDespesas', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_despesas.pdf', 'I');
    }

    public function inadimplencia(Request $request)
    {
        $query = Factura::where('status', 'Pendente')->with('unidade');
        $this->applyDateFilter($query, $request, 'data_vencimento');
        $facturas = $query->get();
        $totalInadimplencia = $facturas->sum('valor_total');
        $periodText = $this->getPeriodText($request);
        $html = View::make('admin.pdf.inadimplencia.index', compact('facturas', 'totalInadimplencia', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_inadimplencia.pdf', 'I');
    }

    public function pagamento(Request $request)
    {
        $query = Pagamento::with('factura');
        $this->applyDateFilter($query, $request, 'data_pagamento');
        $pagamentos = $query->get();
        $totalPagamentos = $pagamentos->sum('valor_pago');
        $periodText = $this->getPeriodText($request);
        $html = View::make('admin.pdf.pagamento.index', compact('pagamentos', 'totalPagamentos', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_pagamentos.pdf', 'I');
    }

    public function visitante(Request $request)
    {
        $query = Visitante::with('unidade');
        $this->applyDateFilter($query, $request, 'data_visita'); // Adjust 'data_visita' to match your Visitante model field
        $visitantes = $query->get();
        $totalVisitantes = $visitantes->count();
        $periodText = $this->getPeriodText($request);
        $html = View::make('admin.pdf.visitante.index', compact('visitantes', 'totalVisitantes', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_visitantes.pdf', 'I');
    }

    public function funcionario(Request $request)
    {
        $funcionarios = Funcionario::with('departamento')->get();
        $funcionariosPorTipo = $funcionarios->groupBy('tipo');
        $totalFuncionarios = $funcionarios->count();
        $periodText = $this->getPeriodText($request); // Included for consistency, though no filter applied
        $html = View::make('admin.pdf.funcionario.index', compact('funcionariosPorTipo', 'totalFuncionarios', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_funcionarios.pdf', 'I');
    }

    public function bloco(Request $request)
    {
        $blocos = Bloco::with('unidades')->get()->map(function ($bloco) {
            $bloco->unidadesPorTipo = $bloco->unidades->groupBy('tipo');
            return $bloco;
        });
        $totalBlocos = Bloco::count();
        $totalUnidades = Unidade::count();
        $periodText = $this->getPeriodText($request);
        $html = View::make('admin.pdf.bloco.index', compact('blocos', 'totalBlocos', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_blocos.pdf', 'I');
    }
}