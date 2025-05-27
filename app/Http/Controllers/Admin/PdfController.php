<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\Acesso;
use App\Models\Visitante;
use App\Models\Morador;
use App\Models\Funcionario;
use App\Models\Bloco;
use App\Models\Despesa;
use App\Models\Factura;
use App\Models\Pagamento;
use App\Models\Edificio;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class PdfController extends Controller
{
    /**
     * Display the index view with filter options for all reports.
     */
    public function index()
    {
        // Data for filters
        $blocos = Bloco::all();
        $tiposMorador = ['Proprietário', 'Inquilino', 'Outro'];
        $generos = ['Masculino', 'Feminino', 'Outro'];
        $tiposUnidade = ['Apartamento', 'Sala Comercial', 'Casa'];
        $statusUnidade = ['disponivel', 'alugada'];
        $tiposPessoaAcesso = ['Visitante', 'Morador', 'Funcionario', 'Prestador de Serviço'];
        $metodosPagamento = ['dinheiro', 'transferencia_bancaria', 'cartao_credito', 'multicaixa', 'paypal', 'outro'];
        $departamentos = Departamento::all();
        $cargos = Funcionario::select('cargo')->distinct()->pluck('cargo');

        return view('admin.pdf.index', compact(
            'blocos', 'tiposMorador', 'generos', 'tiposUnidade', 'statusUnidade',
            'tiposPessoaAcesso', 'metodosPagamento', 'departamentos', 'cargos'
        ));
    }

    /**
     * Configure mPDF settings.
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

    /**
     * Generate text describing the selected period.
     */
    private function getPeriodText(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::parse($request->query('start'));
            $end = Carbon::parse($request->query('end'));
            return 'De ' . $start->format('d/m/Y') . ' a ' . $end->format('d/m/Y');
        }
        return 'Todos os Períodos';
    }

    /**
     * Generate PDF for Morador report.
     */
    public function morador(Request $request)
    {
        $query = Morador::with('unidade');

        if ($request->filled('bloco')) {
            $query->whereHas('unidade', fn($q) => $q->where('bloco_id', $request->bloco));
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('genero')) {
            $query->where('sexo', $request->genero);
        }
        if ($request->filled('idade_min')) {
            $query->where('dt_nascimento', '<=', Carbon::now()->subYears($request->idade_min));
        }
        if ($request->filled('idade_max')) {
            $query->where('dt_nascimento', '>=', Carbon::now()->subYears($request->idade_max + 1));
        }

        $moradores = $query->get();
        $moradoresPorTipo = $moradores->groupBy('tipo');
        $totalMoradores = $moradores->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.morador.index', compact('moradores', 'moradoresPorTipo', 'totalMoradores', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_moradores.pdf', 'I');
    }

    /**
     * Generate PDF for Unidade report.
     */
    public function unidade(Request $request)
    {
        $query = Unidade::with('bloco');

        if ($request->filled('bloco')) {
            $query->where('bloco_id', $request->bloco);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $blocos = Bloco::with(['unidades' => fn($q) => $q->where($query->getQuery()->wheres)])->get();
        $totalUnidades = $query->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.unidade.index', compact('blocos', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_unidades.pdf', 'I');
    }

    /**
     * Generate PDF for Acesso report.
     */
    public function acesso(Request $request)
    {
        $query = Acesso::with('pessoa');

        if ($request->filled('start')) {
            $query->where('data_hora', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_hora', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('tipo_pessoa')) {
            $query->whereIn('tipo_pessoa', (array)$request->tipo_pessoa);
        }
        if ($request->filled('destino')) {
            $query->whereHas('pessoa.unidade', fn($q) => $q->where('numero', $request->destino));
        }

        $acessos = $query->get();
        $totalAcessos = $acessos->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.acesso.index', compact('acessos', 'totalAcessos', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_acessos.pdf', 'I');
    }

    /**
     * Generate PDF for Despesa report.
     */
    public function despesa(Request $request)
    {
        $query = Despesa::query();

        if ($request->filled('start')) {
            $query->where('data_despesa', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_despesa', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        $despesas = $query->get();
        $totalDespesas = $despesas->sum('valor');
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.despesa.index', compact('despesas', 'totalDespesas', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_despesas.pdf', 'I');
    }

    /**
     * Generate PDF for Inadimplência report.
     */
    public function inadimplencia(Request $request)
    {
        $query = Factura::where('status', 'Pendente')->with('unidade');

        if ($request->filled('start')) {
            $query->where('data_vencimento', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_vencimento', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('unidade')) {
            $query->whereHas('unidade', fn($q) => $q->where('numero', $request->unidade));
        }

        $facturas = $query->get();
        $totalInadimplencia = $facturas->sum('valor_total');
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.inadimplencia.index', compact('facturas', 'totalInadimplencia', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_inadimplencia.pdf', 'I');
    }

    /**
     * Generate PDF for Pagamento report.
     */
    public function pagamento(Request $request)
    {
        $query = Pagamento::with('factura');

        if ($request->filled('start')) {
            $query->where('data_pagamento', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_pagamento', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('metodo')) {
            $query->where('metodo_pagamento', $request->metodo);
        }

        $pagamentos = $query->get();
        $totalPagamentos = $pagamentos->sum('valor_pago');
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.pagamento.index', compact('pagamentos', 'totalPagamentos', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_pagamentos.pdf', 'I');
    }

    /**
     * Generate PDF for Visitante report.
     */
    public function visitante(Request $request)
    {
        $query = Visitante::with('unidade');

        if ($request->filled('start')) {
            $query->where('created_at', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('created_at', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('motivo')) {
            $query->where('motivo_visita', 'like', '%' . $request->motivo . '%');
        }

        $visitantes = $query->get();
        $totalVisitantes = $visitantes->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.visitante.index', compact('visitantes', 'totalVisitantes', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_visitantes.pdf', 'I');
    }

    /**
     * Generate PDF for Funcionário report.
     */
    public function funcionario(Request $request)
    {
        $query = Funcionario::with('departamento');

        if ($request->filled('departamento')) {
            $query->where('departamento_id', $request->departamento);
        }
        if ($request->filled('cargo')) {
            $query->where('cargo', $request->cargo);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $funcionarios = $query->get();
        $funcionariosPorTipo = $funcionarios->groupBy('tipo');
        $totalFuncionarios = $funcionarios->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.funcionario.index', compact('funcionariosPorTipo', 'totalFuncionarios', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_funcionarios.pdf', 'I');
    }

    /**
     * Generate PDF for Bloco report.
     */
    public function bloco(Request $request)
    {
        $query = Bloco::with('unidades');

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        $blocos = $query->get()->map(function ($bloco) {
            $bloco->unidadesPorTipo = $bloco->unidades->groupBy('tipo');
            return $bloco;
        });
        $totalBlocos = $query->count();
        $totalUnidades = Unidade::whereIn('bloco_id', $blocos->pluck('id'))->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.bloco.index', compact('blocos', 'totalBlocos', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_blocos.pdf', 'I');
    }

    /**
     * Generate PDF for Edifício report.
     */
    public function edificio(Request $request)
    {
        $query = Edificio::with('bloco');

        if ($request->filled('bloco')) {
            $query->where('bloco_id', $request->bloco);
        }
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        $edificios = $query->get();
        $totalEdificios = $edificios->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.edificio.index', compact('edificios', 'totalEdificios', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_edificios.pdf', 'I');
    }

    // Remove form methods as they are no longer needed
}