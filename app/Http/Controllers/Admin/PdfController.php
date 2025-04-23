<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\Acesso;
use App\Models\Visitante;
use App\Models\Morador;
use App\Models\Funcionario;
use App\Models\Condominio;
use App\Models\Departamento;
use App\Models\Bloco;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class PdfController extends Controller
{
    // Unidade Occupancy Report
    public function selecionarRelatorioUnidadeOccupancy()
    {
        $condominios = Condominio::all();
        $blocos = Bloco::all();
        return view('admin._form._pdf.unidade_occupancy.index', compact('condominios', 'blocos'));
    }

    public function pdf_access_control(Request $request)
    {
        $acessos = Acesso::all();
        $entradas = $acessos->where('tipo', 'Entrada')->count();
        $saidas = $acessos->where('tipo', 'Saida')->count();
        $total = $acessos->count();
    
        $html = View::make('admin.pdf.access_control.index', compact('acessos', 'entradas', 'saidas', 'total'))->render();
    
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Access_Control.pdf', 'I');
        exit;
    }

    // Access Control Report
    public function selecionarRelatorioAccessControl()
    {
        $condominios = Condominio::all();
        return view('admin._form._pdf.access_control.index', compact('condominios'));
    }

    public function pdf_access_control(Request $request)
    {
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');
        $acessos = Acesso::with('pessoa');

        // Filters
        if ($request->filled('data')) {
            $acessos->whereDate('data_hora', $request->data);
        }
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $acessos->whereBetween('data_hora', [$request->data_inicio, $request->data_fim]);
        }
        if ($request->filled('mes') && $request->filled('ano')) {
            $acessos->whereYear('data_hora', $request->ano)->whereMonth('data_hora', $request->mes);
        }
        if ($request->filled('mes_inicio') && $request->filled('mes_fim')) {
            $ano = $request->filled('ano') ? $request->ano : now()->year;
            $dataInicio = Carbon::createFromFormat('Y-m-d', "$ano-$request->mes_inicio-01")->startOfMonth();
            $dataFim = Carbon::createFromFormat('Y-m-d', "$ano-$request->mes_fim-01")->endOfMonth();
            $acessos->whereBetween('data_hora', [$dataInicio, $dataFim]);
        }
        if ($request->filled('tipo_pessoa')) {
            $acessos->where('tipo_pessoa', $request->tipo_pessoa);
        }
        if ($request->filled('tipo')) {
            $acessos->where('tipo', $request->tipo);
        }

        $acessos = $acessos->get();
        $entradas = $acessos->where('tipo', 'Entrada')->count();
        $saidas = $acessos->where('tipo', 'Saida')->count();
        $total = $acessos->count();

        $html = View::make('admin.pdf.access_control.index', compact(
            'acessos', 'entradas', 'saidas', 'total', 'tipo_relatorio', 'request'
        ))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Access_Control.pdf', 'I');
        exit;
    }

    // Visitor Frequency Report
    public function selecionarRelatorioVisitorFrequency()
    {
        $condominios = Condominio::all();
        return view('admin._form._pdf.visitor_frequency.index', compact('condominios'));
    }

    public function pdf_visitor_frequency(Request $request)
    {
        $acessos = Acesso::where('tipo_pessoa', 'visitante')->get();
        $entradas = $acessos->where('tipo', 'Entrada')->count();
        $saidas = $acessos->where('tipo', 'Saida')->count();
        $total = $acessos->count();
    
        $html = View::make('admin.pdf.visitor_frequency.index', compact('acessos', 'entradas', 'saidas', 'total'))->render();
    
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Visitor_Frequency.pdf', 'I');
        exit;
    }

    // Morador Demographics Report
    public function selecionarRelatorioMoradorDemographics()
    {
        $condominios = Condominio::all();
        return view('admin._form._pdf.morador_demographics.index', compact('condominios'));
    }

    public function pdf_morador_demographics(Request $request)
    {
        $acessos = Acesso::where('tipo_pessoa', 'morador')->get();
        $entradas = $acessos->where('tipo', 'Entrada')->count();
        $saidas = $acessos->where('tipo', 'Saida')->count();
        $total = $acessos->count();
    
        $html = View::make('admin.pdf.morador_demographics.index', compact('acessos', 'entradas', 'saidas', 'total'))->render();
    
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Morador_Demographics.pdf', 'I');
        exit;
    }

    // Funcionario Activity Report
    public function selecionarRelatorioFuncionarioActivity()
    {
        $condominios = Condominio::all();
        $departamentos = Departamento::all();
        return view('admin._form._pdf.funcionario_activity.index', compact('condominios', 'departamentos'));
    }

    public function pdf_funcionario_activity(Request $request)
    {
        $acessos = Acesso::where('tipo_pessoa', 'funcionario')->get();
        $entradas = $acessos->where('tipo', 'Entrada')->count();
        $saidas = $acessos->where('tipo', 'Saida')->count();
        $total = $acessos->count();
    
        $html = View::make('admin.pdf.funcionario_activity.index', compact('acessos', 'entradas', 'saidas', 'total'))->render();
    
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Funcionario_Activity.pdf', 'I');
        exit;
    }
}