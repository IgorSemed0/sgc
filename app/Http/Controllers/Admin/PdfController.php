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
        return view('admin._form._pdf.unidade_occupancy.index', compact('condominios'));
    }

    public function pdf_unidade_occupancy(Request $request)
    {
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');
        $unidades = Unidade::query();

        // Filters
        if ($request->filled('condominio_id')) {
            $unidades->where('condominio_id', $request->condominio_id);
        }
        if ($request->filled('bloco')) {
            $unidades->where('bloco', $request->bloco);
        }

        $unidades = $unidades->get();
        $occupied = $unidades->whereNotNull('morador_id')->count();
        $vacant = $unidades->whereNull('morador_id')->count();
        $total = $unidades->count();

        $html = View::make('admin.pdf.unidade_occupancy.index', compact(
            'unidades', 'occupied', 'vacant', 'total', 'tipo_relatorio', 'request'
        ))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Unidade_Occupancy.pdf', 'I');
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
        $acessos = Acesso::with(['morador', 'funcionario', 'visitante']);

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
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');
        $acessos = Acesso::with(['visitante'])->where('tipo_pessoa', 'visitante');

        // Filters
        if ($request->filled('bi')) {
            $acessos->whereHas('visitante', function ($query) use ($request) {
                $query->where('bi', $request->bi);
            });
        }
        if ($request->filled('condominio_id')) {
            $acessos->whereHas('visitante', function ($query) use ($request) {
                $query->where('condominio_id', $request->condominio_id);
            });
        }
        if ($request->filled('data')) {
            $acessos->whereDate('data_hora', $request->data);
        }
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $acessos->whereBetween('data_hora', [$request->data_inicio, $request->data_fim]);
        }
        if ($request->filled('mes') && $request->filled('ano')) {
            $acessos->whereYear('data_hora', $request->ano)->whereMonth('data_hora', $request->mes);
        }

        $acessos = $acessos->get();
        $frequency = $acessos->groupBy('entidade_id')->map->count();
        $total = $acessos->count();

        $html = View::make('admin.pdf.visitor_frequency.index', compact(
            'acessos', 'frequency', 'total', 'tipo_relatorio', 'request'
        ))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Visitor_Frequency.pdf', 'I');
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
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');
        $moradores = Morador::query();

        // Filters
        if ($request->filled('condominio_id')) {
            $moradores->whereHas('unidade', function ($query) use ($request) {
                $query->where('condominio_id', $request->condominio_id);
            });
        }
        if ($request->filled('idade')) {
            $moradores->whereRaw('TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE()) = ?', [$request->idade]);
        }
        if ($request->filled('idade_min') && $request->filled('idade_max')) {
            $moradores->whereRaw('TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE()) BETWEEN ? AND ?', [$request->idade_min, $request->idade_max]);
        }
        if ($request->filled('sexo')) {
            $moradores->where('sexo', $request->sexo);
        }

        $moradores = $moradores->get()->map(function ($morador) {
            $morador->idade = Carbon::parse($morador->data_nascimento)->age;
            return $morador;
        });

        $faixaEtariaGenero = [
            '0-18' => ['masculino' => 0, 'feminino' => 0],
            '19-30' => ['masculino' => 0, 'feminino' => 0],
            '31-50' => ['masculino' => 0, 'feminino' => 0],
            '51+' => ['masculino' => 0, 'feminino' => 0]
        ];

        foreach ($moradores as $morador) {
            $idade = $morador->idade;
            $genero = strtolower($morador->sexo);
            if (!in_array($genero, ['masculino', 'feminino'])) continue;
            if ($idade <= 18) {
                $faixaEtariaGenero['0-18'][$genero]++;
            } elseif ($idade <= 30) {
                $faixaEtariaGenero['19-30'][$genero]++;
            } elseif ($idade <= 50) {
                $faixaEtariaGenero['31-50'][$genero]++;
            } else {
                $faixaEtariaGenero['51+'][$genero]++;
            }
        }

        $totalMasculino = array_sum(array_column($faixaEtariaGenero, 'masculino'));
        $totalFeminino = array_sum(array_column($faixaEtariaGenero, 'feminino'));
        $totalMoradores = $totalMasculino + $totalFeminino;

        $html = View::make('admin.pdf.morador_demographics.index', compact(
            'moradores', 'faixaEtariaGenero', 'totalMasculino', 'totalFeminino', 'totalMoradores', 'tipo_relatorio', 'request'
        ))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Morador_Demographics.pdf', 'I');
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
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');
        $acessos = Acesso::with(['funcionario'])->where('tipo_pessoa', 'funcionario');

        // Filters
        if ($request->filled('condominio_id')) {
            $acessos->whereHas('funcionario', function ($query) use ($request) {
                $query->where('condominio_id', $request->condominio_id);
            });
        }
        if ($request->filled('departamento_id')) {
            $acessos->whereHas('funcionario', function ($query) use ($request) {
                $query->where('departamento_id', $request->departamento_id);
            });
        }
        if ($request->filled('data')) {
            $acessos->whereDate('data_hora', $request->data);
        }
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $acessos->whereBetween('data_hora', [$request->data_inicio, $request->data_fim]);
        }
        if ($request->filled('mes') && $request->filled('ano')) {
            $acessos->whereYear('data_hora', $request->ano)->whereMonth('data_hora', $request->mes);
        }

        $acessos = $acessos->get();
        $entradas = $acessos->where('tipo', 'Entrada')->count();
        $saidas = $acessos->where('tipo', 'Saida')->count();
        $total = $acessos->count();

        $html = View::make('admin.pdf.funcionario_activity.index', compact(
            'acessos', 'entradas', 'saidas', 'total', 'tipo_relatorio', 'request'
        ))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Funcionario_Activity.pdf', 'I');
        exit;
    }
}