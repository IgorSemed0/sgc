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

    /**
     * Configure MPdf to open PDF in browser
     */
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

    public function morador()
    {
        $moradores = Morador::with('unidade')->get();
        $moradoresPorTipo = $moradores->groupBy('tipo');
        $totalMoradores = $moradores->count();
        $html = View::make('admin.pdf.morador.index', compact('moradores', 'moradoresPorTipo', 'totalMoradores'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_moradores.pdf', 'I');
    }

    public function unidade()
    {
        $blocos = Bloco::with('unidade')->get();
        $totalUnidades = Unidade::count();
        $html = View::make('admin.pdf.unidade.index', compact('blocos', 'totalUnidades'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_unidades.pdf', 'I');
    }

    public function acesso()
    {
        $acessos = Acesso::with('pessoa')->get();
        $totalAcessos = $acessos->count();
        $html = View::make('admin.pdf.acesso.index', compact('acessos', 'totalAcessos'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_acessos.pdf', 'I');
    }

    public function despesa()
    {
        $despesas = Despesa::all();
        $totalDespesas = $despesas->sum('valor');
        $html = View::make('admin.pdf.despesa.index', compact('despesas', 'totalDespesas'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_despesas.pdf', 'I');
    }

    public function inadimplencia()
    {
        $facturas = Factura::where('status', 'Pendente')->with('unidade')->get();
        $totalInadimplencia = $facturas->sum('valor_total');
        $html = View::make('admin.pdf.inadimplencia.index', compact('facturas', 'totalInadimplencia'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_inadimplencia.pdf', 'I');
    }

    public function pagamento()
    {
        $pagamentos = Pagamento::with('factura')->get();
        $totalPagamentos = $pagamentos->sum('valor_pago');
        $html = View::make('admin.pdf.pagamento.index', compact('pagamentos', 'totalPagamentos'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_pagamentos.pdf', 'I');
    }

    public function visitante()
    {
        $visitantes = Visitante::with('unidade')->get();
        $totalVisitantes = $visitantes->count();
        $html = View::make('admin.pdf.visitante.index', compact('visitantes', 'totalVisitantes'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_visitantes.pdf', 'I');
    }

    public function funcionario()
    {
        $funcionarios = Funcionario::with('departamento')->get();
        $funcionariosPorTipo = $funcionarios->groupBy('tipo');
        $totalFuncionarios = $funcionarios->count();
        $html = View::make('admin.pdf.funcionario.index', compact('funcionariosPorTipo', 'totalFuncionarios'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_funcionarios.pdf', 'I');
    }
}