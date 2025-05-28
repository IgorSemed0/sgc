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
    public function index()
    {
        // Dados para os filtros
        $blocos = Bloco::all();
        $edificios = Edificio::all();
        $unidades = Unidade::all();
        $departamentos = Departamento::all();
        $tiposMorador = ['proprietario', 'inquilino', 'dependente'];
        $tiposUnidade = ['Apartamento', 'Sala Comercial', 'Casa'];
        $statusUnidade = ['disponivel', 'alugada'];
        $tiposPessoaAcesso = ['Visitante', 'Morador', 'Funcionario'];
        $tiposAcesso = ['Entrada', 'Saída'];
        $categoriasDespesa = ['Manutenção', 'Água', 'Luz', 'Outros'];
        $metodosPagamento = ['dinheiro', 'transferencia_bancaria', 'cartao_credito', 'multicaixa', 'paypal', 'outro'];
        $motivosVisita = ['Entrega', 'Visita', 'Serviço', 'Outro'];
        $tiposFuncionario = ['Porteiro', 'Zelador', 'Administrador'];
        $cargos = Funcionario::select('cargo')->distinct()->pluck('cargo');

        return view('admin.pdf.index', compact(
            'blocos', 'edificios', 'unidades', 'departamentos', 'tiposMorador',
            'tiposUnidade', 'statusUnidade', 'tiposPessoaAcesso', 'tiposAcesso',
            'categoriasDespesa', 'metodosPagamento', 'motivosVisita', 'tiposFuncionario', 'cargos'
        ));
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

    private function getPeriodText(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::parse($request->query('start'));
            $end = Carbon::parse($request->query('end'));
            return 'De ' . $start->format('d/m/Y') . ' a ' . $end->format('d/m/Y');
        }
        return 'Todos os Períodos';
    }

    public function morador(Request $request)
    {
        $query = Morador::with(['unidade', 'inquilino']);
    
        if ($request->filled('bloco')) {
            $query->whereHas('unidade', fn($q) => $q->where('bloco_id', $request->bloco));
        }
        if ($request->filled('unidade')) {
            $query->where('unidade_id', $request->unidade);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
    
        $moradores = $query->get()->map(function ($morador) {
            // Calculate age from birth year
            if ($morador->data_nascimento) {
                $birthYear = \Carbon\Carbon::parse($morador->data_nascimento)->year;
                $currentYear = now()->year;
                $morador->idade = $currentYear - $birthYear;
            } else {
                $morador->idade = null;
            }
            
            // Get associated morador name for dependentes
            if ($morador->tipo === 'dependente' && $morador->dependente_de) {
                $associatedMorador = Morador::find($morador->dependente_de);
                $morador->nome_morador_associado = $associatedMorador 
                    ? $associatedMorador->primeiro_nome . ' ' . $associatedMorador->ultimo_nome 
                    : 'N/A';
            } else {
                $morador->nome_morador_associado = null;
            }
            
            return $morador;
        });
    
        $moradoresPorTipo = $moradores->groupBy('tipo');
        $totalMoradores = $moradores->count();
        $periodText = $this->getPeriodText($request);
    
        $html = View::make('admin.pdf.morador.index', compact('moradores', 'moradoresPorTipo', 'totalMoradores', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_moradores.pdf', 'I');
    }

    public function unidade(Request $request)
    {
        $query = Bloco::with(['unidades' => function ($q) use ($request) {
            if ($request->filled('edificio')) {
                $q->where('edificio_id', $request->edificio);
            }
            if ($request->filled('tipo')) {
                $q->where('tipo', $request->tipo);
            }
            if ($request->filled('status')) {
                $q->where('status', $request->status);
            }
            if ($request->filled('andar')) {
                $q->where('andar', $request->andar);
            }
        }]);
    
        if ($request->filled('bloco')) {
            $query->where('id', $request->bloco);
        }
    
        $blocos = $query->get();
        $totalUnidades = $blocos->sum(fn($bloco) => $bloco->unidades->count());
        $periodText = $this->getPeriodText($request);
    
        $html = View::make('admin.pdf.unidade.index', compact('blocos', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_unidades.pdf', 'I');
    }
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
        if ($request->filled('tipo_acesso')) {
            $query->where('tipo', $request->tipo_acesso);
        }
        if ($request->filled('unidade')) {
            $query->whereHas('pessoa.unidade', fn($q) => $q->where('id', $request->unidade));
        }

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

        if ($request->filled('start')) {
            $query->where('data_despesa', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_despesa', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        if ($request->filled('valor_min')) {
            $query->where('valor', '>=', $request->valor_min);
        }
        if ($request->filled('valor_max')) {
            $query->where('valor', '<=', $request->valor_max);
        }

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

        if ($request->filled('start')) {
            $query->where('data_vencimento', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_vencimento', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('bloco')) {
            $query->whereHas('unidade', fn($q) => $q->where('bloco_id', $request->bloco));
        }
        if ($request->filled('unidade')) {
            $query->where('unidade_id', $request->unidade);
        }
        if ($request->filled('valor_min')) {
            $query->where('valor_total', '>=', $request->valor_min);
        }
        if ($request->filled('valor_max')) {
            $query->where('valor_total', '<=', $request->valor_max);
        }

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
        $query = Pagamento::with('factura.unidade');

        if ($request->filled('start')) {
            $query->where('data_pagamento', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_pagamento', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('bloco')) {
            $query->whereHas('factura.unidade', fn($q) => $q->where('bloco_id', $request->bloco));
        }
        if ($request->filled('unidade')) {
            $query->whereHas('factura', fn($q) => $q->where('unidade_id', $request->unidade));
        }
        if ($request->filled('metodo')) {
            $query->where('metodo_pagamento', $request->metodo);
        }
        if ($request->filled('valor_min')) {
            $query->where('valor_pago', '>=', $request->valor_min);
        }
        if ($request->filled('valor_max')) {
            $query->where('valor_pago', '<=', $request->valor_max);
        }

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

        if ($request->filled('start')) {
            $query->where('data_visita', '>=', Carbon::parse($request->start));
        }
        if ($request->filled('end')) {
            $query->where('data_visita', '<=', Carbon::parse($request->end));
        }
        if ($request->filled('bloco')) {
            $query->whereHas('unidade', fn($q) => $q->where('bloco_id', $request->bloco));
        }
        if ($request->filled('unidade')) {
            $query->where('unidade_id', $request->unidade);
        }
        if ($request->filled('motivo')) {
            $query->where('motivo_visita', $request->motivo);
        }

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
        $query = Funcionario::with('departamento');

        if ($request->filled('departamento')) {
            $query->where('departamento_id', $request->departamento);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('cargo')) {
            $query->where('cargo', $request->cargo);
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

    public function bloco(Request $request)
    {
        $query = Bloco::with(['unidades' => function($q) use ($request) {
            if ($request->filled('tipo_unidade')) {
                $q->where('tipo', $request->tipo_unidade);
            }
            if ($request->filled('status_unidade')) {
                $q->where('status', $request->status_unidade);
            }
        }]);

        $blocos = $query->get();
        $totalBlocos = $blocos->count();
        $totalUnidades = $blocos->sum(fn($bloco) => $bloco->unidades->count());
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.bloco.index', compact('blocos', 'totalBlocos', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_blocos.pdf', 'I');
    }

    public function ocupacaoUnidades(Request $request)
    {
        $query = Unidade::with('bloco', 'edificio');

        if ($request->filled('bloco')) {
            $query->where('bloco_id', $request->bloco);
        }
        if ($request->filled('edificio')) {
            $query->where('edificio_id', $request->edificio);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('andar')) {
            $query->where('andar', $request->andar);
        }

        $unidades = $query->get();
        $totalUnidades = $unidades->count();
        $periodText = $this->getPeriodText($request);

        $html = View::make('admin.pdf.ocupacao_unidades.index', compact('unidades', 'totalUnidades', 'periodText'))->render();
        $mpdf = $this->configureMpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('relatorio_ocupacao_unidades.pdf', 'I');
    }
}