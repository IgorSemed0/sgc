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

    public function morador()
    {
        $moradores = Morador::with('unidade')->get();
        $moradoresPorTipo = $moradores->groupBy('tipo');
        $totalMoradores = $moradores->count();
        $html = View::make('admin.pdf.morador.index', compact('moradores', 'moradoresPorTipo', 'totalMoradores'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_moradores.pdf', 'D');
    }

    public function unidade()
    {
        $blocos = Bloco::with('unidade')->get();
        $totalUnidades = Unidade::count();
        $html = View::make('admin.pdf.unidade.index', compact('blocos', 'totalUnidades'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_unidades.pdf', 'D');
    }

    public function acesso()
    {
        $acessos = Acesso::with('pessoa')->get();
        $totalAcessos = $acessos->count();
        $html = View::make('admin.pdf.acesso.index', compact('acessos', 'totalAcessos'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_acessos.pdf', 'D');
    }

    public function despesa()
    {
        $despesas = Despesa::all();
        $totalDespesas = $despesas->sum('valor');
        $html = View::make('admin.pdf.despesa.index', compact('despesas', 'totalDespesas'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_despesas.pdf', 'D');
    }

    public function inadimplencia()
    {
        $facturas = Factura::where('status', 'Pendente')->with('unidade')->get();
        $totalInadimplencia = $facturas->sum('valor_total');
        $html = View::make('admin.pdf.inadimplencia.index', compact('facturas', 'totalInadimplencia'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_inadimplencia.pdf', 'D');
    }

    public function pagamento()
    {
        $pagamentos = Pagamento::with('factura')->get();
        $totalPagamentos = $pagamentos->sum('valor_pago');
        $html = View::make('admin.pdf.pagamento.index', compact('pagamentos', 'totalPagamentos'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_pagamentos.pdf', 'D');
    }

    public function visitante()
    {
        $visitantes = Visitante::with('unidade')->get();
        $totalVisitantes = $visitantes->count();
        $html = View::make('admin.pdf.visitante.index', compact('visitantes', 'totalVisitantes'))->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_visitantes.pdf', 'D');
    }
}