<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class PdfController extends Controller
{
    

    public function pdf_fornecedor()
    {
        $fornecedores = Fornecedor::all();
        $html = View::make('admin.pdf.fornecedor.index', compact('fornecedores'))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Fornecedores.pdf', 'I');
        exit;
    }

    public function pdf_dependente()
    {
        $dependentes = Dependente::join('funcionarios', 'dependentes.it_id_funcionario', '=', 'funcionarios.id')
            ->select('dependentes.*', 'funcionarios.vc_pnome as pnome_f', 'funcionarios.vc_unome as unome_f')
            ->get();

        $html = View::make('admin.pdf.dependente.index', compact('dependentes'))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Dependentes.pdf', 'I');
        exit;
    }

    public function pdf_medicamento()
    {
        $medicamentos = Medicamento::join('categoria_medicamentos', 'medicamentos.it_id_categoria', '=', 'categoria_medicamentos.id')
            ->select('medicamentos.*', 'categoria_medicamentos.vc_nome as categoria_nome')
            ->get();

        $html = View::make('admin.pdf.medicamento.index', compact('medicamentos'))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Medicamento.pdf', 'I');
        exit;
    }

    public function selecionarCategoria()
    {
        $categorias = CategoriaMedicamento::all();
        return view('admin.pdf.medicamento.selecionar_categoria', compact('categorias'));
    }

    public function pdfMedicamentoPorCategoria(Request $request)
    {
        $id = $request->dados;
        $categoria = CategoriaMedicamento::findOrFail($id);
        $medicamentos = Medicamento::where('it_id_categoria', $id)->get();

        $html = View::make('admin.pdf.medicamento.por_categoria', compact('medicamentos', 'categoria'))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Medicamentos_{$categoria->vc_nome}.pdf", 'I');
        exit;
    }

    public function pdf_reciboDeVenda($id)
    {
        //dd($id);
        $venda = Venda::with(['funcionario', 'dependente', 'vendaprodutos.produto'])->findOrFail($id);
        $html = View::make('admin.pdf.venda_recibo.index', compact('venda'))->render();

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("recibo_de_venda.pdf", 'I');
        exit;
    }


    public function SaidasDiarias()
    {
    
        $hoje = now()->toDateString();
    
    
        $saidas = Saida::whereDate('dt_data_saida', $hoje)
            ->with('produto')
            ->get();
    
    
        $categorias = $saidas->groupBy(function ($saida) {
            return $saida->produto->vc_tipo ?? 'Sem Categoria';
        });
        $totalCategoria= $categorias->count('id');
    
        $totalGeral = $saidas->/*sum('fl_quantidade_por_unidade');*/count('id');
    
        $totalPorCategoria = [];
        foreach ($categorias as $categoria => $saidasPorCategoria) {
            $totalPorCategoria[$categoria] = $saidasPorCategoria->count('id');
        }
    
        $html = View::make('admin.pdf.saidas.diarias', compact('saidas', 'hoje', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
    
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Saidas_Diarias_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function saidasSemanais(){
    
    
        $hoje = now()->toDateString();
        $inicioSemana = Carbon::now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        $fimSemana = Carbon::now()->endOfWeek(Carbon::SUNDAY)->toDateString();
    
    
        $saidas = Saida::whereBetween('dt_data_saida', [$inicioSemana, $fimSemana])
            ->with('produto')
            ->get();
    
        $categorias = $saidas->groupBy(function ($saida) {
            return $saida->produto->vc_tipo ?? 'Sem Categoria';
        });
        $totalCategoria= $categorias->count('id');
        $totalGeral = $saidas->count('id');
    
        $totalPorCategoria = [];
        foreach ($categorias as $categoria => $saidasPorCategoria) {
            $totalPorCategoria[$categoria] = $saidasPorCategoria->count('id');
        }
    
        $html = View::make('admin.pdf.saidas.semanais', compact('saidas', 'hoje', 'inicioSemana', 'fimSemana', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
    
    
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Saidas_Semanais_{$hoje}.pdf", 'I');
        exit;
    
    }
    
    public function saidasMensais(){
    
    
        $hoje = now()->toDateString();
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();
        $fimMes = Carbon::now()->endOfMonth()->toDateString();
    
    
        $saidas = Saida::whereBetween('dt_data_saida', [$inicioMes, $fimMes])
            ->with('produto')
            ->get();
    
    
        $categorias = $saidas->groupBy(fn($saida) => $saida->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria= $categorias->count('id');
        $totalGeral = $saidas->count('id');
    
    
        $totalPorCategoria = $categorias->map(fn($saidasPorCategoria) => $saidasPorCategoria->count('id'));
    
    
        $html = View::make('admin.pdf.saidas.mensais', compact('saidas', 'hoje', 'inicioMes', 'fimMes', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Saidas_Mensais_{$hoje}.pdf", 'I');
        exit;
    
    }
    
    public function saidasTrimestrais(){
    
        $hoje = now()->toDateString();
        $inicioTrimestre = Carbon::now()->startOfQuarter()->toDateString();
        $fimTrimestre = Carbon::now()->endOfQuarter()->toDateString();
    
        $saidas = Saida::whereBetween('dt_data_saida', [$inicioTrimestre, $fimTrimestre])
            ->with('produto')
            ->get();
    
        $categorias = $saidas->groupBy(fn($saida) => $saida->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria= $categorias->count('id');
        $totalGeral = $saidas->count('id');
        $totalPorCategoria = $categorias->map(fn($saidasPorCategoria) => $saidasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.saidas.trimestrais', compact('saidas', 'hoje', 'inicioTrimestre', 'fimTrimestre', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Saidas_Trimestrais_{$hoje}.pdf", 'I');
        exit;
    
    }
    public function saidasSemestrais(){
    
        $hoje = now()->toDateString();
        $mesAtual = now()->month;
        if ($mesAtual <= 6) {
            $inicioSemestre = Carbon::now()->startOfYear()->toDateString(); // Janeiro
            $fimSemestre = Carbon::now()->startOfYear()->addMonths(5)->endOfMonth()->toDateString(); // Junho
        } else {
            $inicioSemestre = Carbon::now()->startOfYear()->addMonths(6)->toDateString(); // Julho
            $fimSemestre = Carbon::now()->endOfYear()->toDateString(); // Dezembro
        }
    
        $saidas = Saida::whereBetween('dt_data_saida', [$inicioSemestre, $fimSemestre])
            ->with('produto')
            ->get();
    
        $categorias = $saidas->groupBy(fn($saida) => $saida->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria= $categorias->count('id');
        $totalGeral = $saidas->count('id');
        $totalPorCategoria = $categorias->map(fn($saidasPorCategoria) => $saidasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.saidas.semestrais', compact('saidas', 'hoje', 'inicioSemestre', 'fimSemestre', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Saidas_Semestrais_{$hoje}.pdf", 'I');
        exit;
    
    }
    
    public function saidasAnuais(){
    
        $hoje = now()->toDateString();
        $inicioAno = Carbon::now()->startOfYear()->toDateString();
        $fimAno = Carbon::now()->endOfYear()->toDateString();
    
        $saidas = Saida::whereBetween('dt_data_saida', [$inicioAno, $fimAno])
            ->with('produto')
            ->get();
    
        $categorias = $saidas->groupBy(fn($saida) => $saida->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria= $categorias->count('id');
        $totalGeral = $saidas->count('id');
        $totalPorCategoria = $categorias->map(fn($saidasPorCategoria) => $saidasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.saidas.anuais', compact('saidas', 'hoje', 'inicioAno', 'fimAno', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Saidas_Anuais_{$hoje}.pdf", 'I');
        exit;
    
    }
    
    public function selecionarSaidas(Request $request)
    {
        $tipo = $request->input('tipo_relatorio');
    
        switch ($tipo) {
            case 'diario':
                return redirect()->route('pdf.saida.diarias');
            case 'semanal':
                return redirect()->route('pdf.saida.semanais');
            case 'mensal':
                return redirect()->route('pdf.saida.mensais');
            case 'trimestral':
                return redirect()->route('pdf.saida.trimestrais');
            case 'semestral':
                return redirect()->route('pdf.saida.semestrais');
            case 'anual':
                return redirect()->route('pdf.saida.anuais');
            default:
                return redirect()->back()->with('error', 'Selecione um tipo de relatório válido.');
        }
    }
    
    
    
    public function selecionarEntradas(Request $request)
    {
        $tipo = $request->input('tipo_relatorio');
    
        switch ($tipo) {
            case 'diario':
                return redirect()->route('pdf.entrada.diarias');
            case 'semanal':
                return redirect()->route('pdf.entrada.semanais');
            case 'mensal':
                return redirect()->route('pdf.entrada.mensais');
            case 'trimestral':
                return redirect()->route('pdf.entrada.trimestrais');
            case 'semestral':
                return redirect()->route('pdf.entrada.semestrais');
            case 'anual':
                return redirect()->route('pdf.entrada.anuais');
            default:
                return redirect()->back()->with('error', 'Selecione um tipo de relatório válido.');
        }
    }
    
    public function entradasDiarias()
    {
        $hoje = now()->toDateString();
        $entradas = Entrada::whereDate('dt_data_entrada', $hoje)->with('produto')->get();
    
        $categorias = $entradas->groupBy(fn($entrada) => $entrada->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria = $categorias->count('id');
        $totalGeral = $entradas->count('id');
        $totalPorCategoria = $categorias->map(fn($entradasPorCategoria) => $entradasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.entradas.diarias', compact('entradas', 'hoje', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Entradas_Diarias_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function entradasSemanais()
    {
        $hoje = now()->toDateString();
        $inicioSemana = Carbon::now()->startOfWeek(Carbon::SUNDAY)->toDateString();
        $fimSemana = Carbon::now()->endOfWeek(Carbon::SUNDAY)->toDateString();
    
        $entradas = Entrada::whereBetween('dt_data_entrada', [$inicioSemana, $fimSemana])->with('produto')->get();
    
        $categorias = $entradas->groupBy(fn($entrada) => $entrada->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria = $categorias->count('id');
        $totalGeral = $entradas->count('id');
        $totalPorCategoria = $categorias->map(fn($entradasPorCategoria) => $entradasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.entradas.semanais', compact('entradas', 'hoje', 'inicioSemana', 'fimSemana', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Entradas_Semanais_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function entradasMensais()
    {
        $hoje = now()->toDateString();
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();
        $fimMes = Carbon::now()->endOfMonth()->toDateString();
    
        $entradas = Entrada::whereBetween('dt_data_entrada', [$inicioMes, $fimMes])->with('produto')->get();
    
        $categorias = $entradas->groupBy(fn($entrada) => $entrada->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria = $categorias->count('id');
        $totalGeral = $entradas->count('id');
        $totalPorCategoria = $categorias->map(fn($entradasPorCategoria) => $entradasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.entradas.mensais', compact('entradas', 'hoje', 'inicioMes', 'fimMes', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Entradas_Mensais_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function entradasTrimestrais()
    {
        $hoje = now()->toDateString();
        $inicioTrimestre = Carbon::now()->startOfQuarter()->toDateString();
        $fimTrimestre = Carbon::now()->endOfQuarter()->toDateString();
    
        $entradas = Entrada::whereBetween('dt_data_entrada', [$inicioTrimestre, $fimTrimestre])->with('produto')->get();
    
        $categorias = $entradas->groupBy(fn($entrada) => $entrada->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria = $categorias->count('id');
        $totalGeral = $entradas->count('id');
        $totalPorCategoria = $categorias->map(fn($entradasPorCategoria) => $entradasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.entradas.trimestrais', compact('entradas', 'hoje', 'inicioTrimestre', 'fimTrimestre', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Entradas_Trimestrais_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function entradasSemestrais()
    {
        $hoje = now()->toDateString();
        $inicioSemestre = Carbon::now()->month <= 6 ? Carbon::now()->startOfYear()->toDateString() : Carbon::now()->startOfYear()->addMonths(6)->toDateString();
        $fimSemestre = Carbon::now()->month <= 6 ? Carbon::now()->startOfYear()->addMonths(5)->endOfMonth()->toDateString() : Carbon::now()->endOfYear()->toDateString();
    
        $entradas = Entrada::whereBetween('dt_data_entrada', [$inicioSemestre, $fimSemestre])->with('produto')->get();
    
        $categorias = $entradas->groupBy(fn($entrada) => $entrada->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria = $categorias->count('id');
        $totalGeral = $entradas->count('id');
        $totalPorCategoria = $categorias->map(fn($entradasPorCategoria) => $entradasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.entradas.semestrais', compact('entradas', 'hoje', 'inicioSemestre', 'fimSemestre', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Entradas_Semestrais_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function entradasAnuais()
    {
        $hoje = now()->toDateString();
        $inicioAno = Carbon::now()->startOfYear()->toDateString();
        $fimAno = Carbon::now()->endOfYear()->toDateString();
    
        $entradas = Entrada::whereBetween('dt_data_entrada', [$inicioAno, $fimAno])->with('produto')->get();
    
        $categorias = $entradas->groupBy(fn($entrada) => $entrada->produto->vc_tipo ?? 'Sem Categoria');
        $totalCategoria = $categorias->count('id');
        $totalGeral = $entradas->count('id');
        $totalPorCategoria = $categorias->map(fn($entradasPorCategoria) => $entradasPorCategoria->count('id'));
    
        $html = View::make('admin.pdf.entradas.anuais', compact('entradas', 'hoje', 'inicioAno', 'fimAno', 'categorias', 'totalGeral', 'totalPorCategoria','totalCategoria'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Entradas_Anuais_{$hoje}.pdf", 'I');
        exit;
    }

    // Stock reports for all status categories
    public function estoqueGeral()
    {
        $hoje = now()->toDateString();
        $estoque_produtos = EstoqueProduto::with(['produto', 'fornecedor'])->get();
        
        // Group by status
        $categorias = $estoque_produtos->groupBy(function ($item) {
            if ($item->percentagem_estoque <= 10) {
                return 'Crítico';
            } elseif ($item->percentagem_estoque <= 30) {
                return 'Baixo';
            } elseif ($item->percentagem_estoque <= 70) {
                return 'Moderado';
            } else {
                return 'Adequado';
            }
        });
        
        $totalPorCategoria = [];
        foreach ($categorias as $categoria => $produtos) {
            $totalPorCategoria[$categoria] = $produtos->count();
        }
        
        $totalGeral = $estoque_produtos->count();
        
        $html = View::make('admin.pdf.estoque.geral', compact('estoque_produtos', 'hoje', 'categorias', 'totalPorCategoria', 'totalGeral'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Estoque_Geral_{$hoje}.pdf", 'I');
        exit;
    }
    
    // Report for (<=10%)
    public function estoqueCritico()
    {
        $hoje = now()->toDateString();
        $estoque_produtos = EstoqueProduto::with(['produto', 'fornecedor'])
            ->whereRaw('(it_quantidade_atual / it_quantidade_inicial) * 100 <= 10')
            ->get();
        
        $totalGeral = $estoque_produtos->count();
        
        $html = View::make('admin.pdf.estoque.critico', compact('estoque_produtos', 'hoje', 'totalGeral'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Estoque_Critico_{$hoje}.pdf", 'I');
        exit;
    }
    
    // Report for (>10% and <=30%)
    public function estoqueBaixo()
    {
        $hoje = now()->toDateString();
        $estoque_produtos = EstoqueProduto::with(['produto', 'fornecedor'])
            ->whereRaw('(it_quantidade_atual / it_quantidade_inicial) * 100 > 10')
            ->whereRaw('(it_quantidade_atual / it_quantidade_inicial) * 100 <= 30')
            ->get();
        
        $totalGeral = $estoque_produtos->count();
        
        $html = View::make('admin.pdf.estoque.baixo', compact('estoque_produtos', 'hoje', 'totalGeral'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Estoque_Baixo_{$hoje}.pdf", 'I');
        exit;
    }
    
    // Report for (>30% and <=70%)
    public function estoqueModerate()
    {
        $hoje = now()->toDateString();
        $estoque_produtos = EstoqueProduto::with(['produto', 'fornecedor'])
            ->whereRaw('(it_quantidade_atual / it_quantidade_inicial) * 100 > 30')
            ->whereRaw('(it_quantidade_atual / it_quantidade_inicial) * 100 <= 70')
            ->get();
        
        $totalGeral = $estoque_produtos->count();
        
        $html = View::make('admin.pdf.estoque.moderado', compact('estoque_produtos', 'hoje', 'totalGeral'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Estoque_Moderado_{$hoje}.pdf", 'I');
        exit;
    }
    
    // Report for (>70%)
    public function estoqueAdequado()
    {
        $hoje = now()->toDateString();
        $estoque_produtos = EstoqueProduto::with(['produto', 'fornecedor'])
            ->whereRaw('(it_quantidade_atual / it_quantidade_inicial) * 100 > 70')
            ->get();
        
        $totalGeral = $estoque_produtos->count();
        
        $html = View::make('admin.pdf.estoque.adequado', compact('estoque_produtos', 'hoje', 'totalGeral'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Estoque_Adequado_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function estoqueProximoVencimento()
    {
        $hoje = now()->toDateString();
        $limit = now()->addDays(30)->toDateString();
        
        $estoque_produtos = EstoqueProduto::with(['produto', 'fornecedor'])
            ->where('dt_validade', '>=', $hoje)
            ->where('dt_validade', '<=', $limit)
            ->where('it_quantidade_atual', '>', 0)
            ->get();
        
        $totalGeral = $estoque_produtos->count();
        
        $html = View::make('admin.pdf.estoque.vencimento', compact('estoque_produtos', 'hoje', 'limit', 'totalGeral'))->render();
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Estoque_Proximo_Vencimento_{$hoje}.pdf", 'I');
        exit;
    }
    
    public function selecionarEstoque(Request $request)
    {
        $tipo = $request->input('tipo_relatorio');
    
        switch ($tipo) {
            case 'geral':
                return redirect()->route('pdf.estoque.geral');
            case 'critico':
                return redirect()->route('pdf.estoque.critico');
            case 'baixo':
                return redirect()->route('pdf.estoque.baixo');
            case 'moderado':
                return redirect()->route('pdf.estoque.moderado');
            case 'adequado':
                return redirect()->route('pdf.estoque.adequado');
            case 'vencimento':
                return redirect()->route('pdf.estoque.vencimento');
            default:
                return redirect()->back()->with('error', 'Selecione um tipo de relatório válido.');
        }
    }
    
    public function pdf_associado(Request $request)
{
    $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');

    $associados = Associado::with(['proveniencia', 'funcao'])->select('associados.*');

    // Filtros
    if ($request->filled('it_id_proveniencia')) {
        $associados->where('it_id_proveniencia', $request->it_id_proveniencia);
    }

    if ($request->filled('it_id_funcao')) {
        $associados->where('it_id_funcao', $request->it_id_funcao);
    }

    if ($request->filled('idade_min') || $request->filled('idade_max')) {
        $min = $request->input('idade_min', 0);
        $max = $request->input('idade_max', 150);
        $associados->whereRaw('TIMESTAMPDIFF(YEAR, dt_nascimento, CURDATE()) BETWEEN ? AND ?', [$min, $max]);
    } elseif ($request->filled('idade')) {
        $associados->whereRaw('TIMESTAMPDIFF(YEAR, dt_nascimento, CURDATE()) = ?', [$request->idade]);
    }

    $associados = $associados->get();

    // Adiciona idade
    $associados->map(function ($a) {
        $a->idade = \Carbon\Carbon::parse($a->dt_nascimento)->age;
        return $a;
    });

    // Flags para os filtros
    $temIdade = $request->filled('idade');
    $temIntervaloIdade = $request->filled('idade_min') && $request->filled('idade_max');
    $temFuncao = $request->filled('it_id_funcao');
    $temProveniencia = $request->filled('it_id_proveniencia');

    // Colunas extras para a tabela
    $colunasExtras = [];
    if ($temFuncao) $colunasExtras[] = 'Função';
    if ($temProveniencia) $colunasExtras[] = 'Proveniência';

    $faixaEtariaGenero = [];

    foreach ($associados as $a) {
        $idade = $a->idade;
        $genero = strtolower($a->vc_genero);

        if (!in_array($genero, ['masculino', 'feminino'])) continue;

        // Faixa etária
        if ($idade <= 18) $faixa = '0-18';
        elseif ($idade <= 30) $faixa = '19-30';
        elseif ($idade <= 50) $faixa = '31-50';
        else $faixa = '51+';

        // Se houver filtro de idade, use esse intervalo específico
        if ($temIntervaloIdade) {
            $faixa = $request->input('idade_min') . ' - ' . $request->input('idade_max') . ' anos';
        } elseif ($temIdade) {
            $faixa = $request->input('idade') . ' anos';
        }

        $chaveGrupo = [];

        if ($temFuncao) $chaveGrupo[] = $a->funcao->vc_nome ?? 'Sem função';
        if ($temProveniencia) $chaveGrupo[] = $a->proveniencia->vc_nome ?? 'Sem proveniência';

        // SOMENTE se não tiver nenhum filtro, adiciona a faixa como chave principal
        if (!$temFuncao && !$temProveniencia && !$temIdade && !$temIntervaloIdade) {
            $chaveGrupo[] = $faixa;
        }

        $chave = implode('|', $chaveGrupo) ?: $faixa;

        if (!isset($faixaEtariaGenero[$chave])) {
            $faixaEtariaGenero[$chave] = [
                'funcao' => $a->funcao->vc_nome ?? '',
                'proveniencia' => $a->proveniencia->vc_nome ?? '',
                'faixa' => $faixa,
                'masculino' => 0,
                'feminino' => 0
            ];
        }

        $faixaEtariaGenero[$chave][$genero]++;
    }

    $totalMasculino = array_sum(array_column($faixaEtariaGenero, 'masculino'));
    $totalFeminino = array_sum(array_column($faixaEtariaGenero, 'feminino'));
    $totalAssociados = $totalMasculino + $totalFeminino;

    // Geração do PDF
    if ($tipo_relatorio == 'quantitativo') {
        $html = View::make('admin.pdf.associado.index', compact(
            'faixaEtariaGenero',
            'totalMasculino',
            'totalFeminino',
            'totalAssociados',
            'tipo_relatorio',
            'request',
            'temIdade',
            'temIntervaloIdade',
            'temFuncao',
            'temProveniencia',
            'colunasExtras'
        ))->render();
    } else {
        $html = View::make('admin.pdf.associado.index', compact(
            'associados',
            'tipo_relatorio',
            'request'
        ))->render();
    }

    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
    $mpdf->SetMargins(10, 10, 10);
    $mpdf->WriteHTML($html);
    $mpdf->Output('Relatorio_Associados.pdf', 'I');
    exit;
}

    
    
    
    
    
    public function selecionarRelatorioAssociado(){

        return view('admin._form._pdf.associado.index');
    }//feito
    
    public function pdf_marcacao_consulta(Request $request)
    {
        //dd($request);
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');

        $marcacoes = MarcacaoConsulta::with([
            'funcionario',
            'triagem.associado',
            'consulta'
        ])
        ->select('marcacao_consultas.*')
        ->leftJoin('triagens', 'triagens.id', '=', 'marcacao_consultas.it_id_triagem')
        ->leftJoin('associados', 'associados.id', '=', 'triagens.it_id_associado');

        // Filtros de data única
        if ($request->filled('data')) {
            $marcacoes->whereDate('marcacao_consultas.dt_consulta', $request->data);
        }

        // Filtro por intervalo de datas
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $marcacoes->whereBetween('marcacao_consultas.dt_consulta', [$request->data_inicio, $request->data_fim]);
        }

        // Filtro por intervalo de meses
        if ($request->filled('mes_inicio') && $request->filled('mes_fim')) {
            $ano = $request->filled('ano') ? $request->ano : now()->year;
            $mesInicio = str_pad($request->mes_inicio, 2, '0', STR_PAD_LEFT);
            $mesFim = str_pad($request->mes_fim, 2, '0', STR_PAD_LEFT);

            $dataInicio = \Carbon\Carbon::createFromFormat('Y-m-d', "$ano-$mesInicio-01")->startOfMonth();
            $dataFim = \Carbon\Carbon::createFromFormat('Y-m-d', "$ano-$mesFim-01")->endOfMonth();

            $marcacoes->whereBetween('marcacao_consultas.dt_consulta', [$dataInicio->toDateString(), $dataFim->toDateString()]);
        }
        // Filtro por mês único
        elseif ($request->filled('mes') && $request->filled('ano')) {
            $marcacoes->whereYear('marcacao_consultas.dt_consulta', $request->ano);
            $marcacoes->whereMonth('marcacao_consultas.dt_consulta', $request->mes);
        }
        // Filtro por ano
        elseif ($request->filled('ano')) {
            $marcacoes->whereYear('marcacao_consultas.dt_consulta', $request->ano);
        }

        // Filtro por idade única
        if ($request->filled('idade')) {
            $marcacoes->whereRaw('TIMESTAMPDIFF(YEAR, associados.dt_nascimento, CURDATE()) = ?', [$request->idade]);
        }

        // Filtro por intervalo de idades
        if ($request->filled('idade_min') && $request->filled('idade_max')) {
            $marcacoes->whereRaw('TIMESTAMPDIFF(YEAR, associados.dt_nascimento, CURDATE()) BETWEEN ? AND ?', [$request->idade_min, $request->idade_max]);
        }

        $marcacoes = $marcacoes->get();

        // Adiciona idade ao associado
        $marcacoes = $marcacoes->map(function ($marcacao) {
            $associado = $marcacao->triagem->associado;
            $associado->idade = \Carbon\Carbon::parse($associado->dt_nascimento)->age;
            return $marcacao;
        });

        // Totais por faixa etária e gênero
        $faixaEtariaGenero = [
            '0-18' => ['masculino' => 0, 'feminino' => 0],
            '19-30' => ['masculino' => 0, 'feminino' => 0],
            '31-50' => ['masculino' => 0, 'feminino' => 0],
            '51+' => ['masculino' => 0, 'feminino' => 0]
        ];

        foreach ($marcacoes as $marcacao) {
            $idade = $marcacao->triagem->associado->idade;
            $genero = strtolower($marcacao->triagem->associado->vc_genero);

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
        $totalMarcacoes = $totalMasculino + $totalFeminino;

        if ($tipo_relatorio == 'quantitativo') {
            $html = View::make('admin.pdf.marcacao_consulta.index', compact(
                'faixaEtariaGenero',
                'totalMasculino',
                'totalFeminino',
                'totalMarcacoes',
                'tipo_relatorio',
                'request'
            ))->render();
        } else {
            $html = View::make('admin.pdf.marcacao_consulta.index', compact('marcacoes', 'tipo_relatorio'))->render();
        }

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_MarcacaoConsulta.pdf', 'I');
        exit;
    }

    public function selecionarRelatorioMarcacaoConsulta(){

        return view('admin._form._pdf.marcacao_consulta.index');
    }//feito

    public function pdf_consultas(Request $request)
    {
        $hoje = now()->toDateString();
        
        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');
    
        $consultas = Consulta::with([
                'especialidade',
                'triagem.associado',
            ])
            ->select('consultas.*')
            ->leftJoin('triagens', 'triagens.id', '=', 'consultas.it_id_triagem')
            ->leftJoin('associados', 'associados.id', '=', 'triagens.it_id_associado'); 
    
        // Filtros de data única
        if ($request->filled('data')) {
            $consultas->whereDate('consultas.dt_consulta', $request->data);
        }
    
        // Filtro por intervalo de datas
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $consultas->whereBetween('consultas.dt_consulta', [$request->data_inicio, $request->data_fim]);
        }
    
        // Filtro por intervalo de meses (tem prioridade sobre o mês único)
        if ($request->filled('mes_inicio') && $request->filled('mes_fim')) {
            $ano = $request->filled('ano') ? $request->ano : now()->year;
            $mesInicio = str_pad($request->mes_inicio, 2, '0', STR_PAD_LEFT);
            $mesFim = str_pad($request->mes_fim, 2, '0', STR_PAD_LEFT);
    
            $dataInicio = \Carbon\Carbon::createFromFormat('Y-m-d', "$ano-$mesInicio-01")->startOfMonth();
            $dataFim = \Carbon\Carbon::createFromFormat('Y-m-d', "$ano-$mesFim-01")->endOfMonth();
    
            $consultas->whereBetween('consultas.dt_consulta', [$dataInicio->toDateString(), $dataFim->toDateString()]);
        } 
        // Filtro por mês único
        elseif ($request->filled('mes') && $request->filled('ano')) {
            $consultas->whereYear('consultas.dt_consulta', $request->ano);
            $consultas->whereMonth('consultas.dt_consulta', $request->mes);
        }
    
        // Filtro por ano (caso não tenha sido usado com mês)
        elseif ($request->filled('ano')) {
            $consultas->whereYear('consultas.dt_consulta', $request->ano);
        }
    
        // Filtro por idade
        if ($request->filled('idade')) {
            $consultas->whereRaw('TIMESTAMPDIFF(YEAR, associados.dt_nascimento, CURDATE()) = ?', [$request->idade]);
        }
    
        // Filtro por intervalo de idades
        if ($request->filled('idade_min') && $request->filled('idade_max')) {
            $consultas->whereRaw('TIMESTAMPDIFF(YEAR, associados.dt_nascimento, CURDATE()) BETWEEN ? AND ?', [$request->idade_min, $request->idade_max]);
        }
    
        // Recupera as consultas
        $consultas = $consultas->get();
    
        // Adiciona idade aos associados
        $consultas = $consultas->map(function ($consulta) {
            $associado = $consulta->triagem->associado;
            $associado->idade = \Carbon\Carbon::parse($associado->dt_nascimento)->age;
            return $consulta;
        });
    
        // Calcula totais por faixa etária e gênero
        $faixaEtariaGenero = [
            '0-18' => ['masculino' => 0, 'feminino' => 0],
            '19-30' => ['masculino' => 0, 'feminino' => 0],
            '31-50' => ['masculino' => 0, 'feminino' => 0],
            '51+' => ['masculino' => 0, 'feminino' => 0]
        ];
    
        foreach ($consultas as $consulta) {
            $idade = $consulta->triagem->associado->idade;
            $genero = strtolower($consulta->triagem->associado->vc_genero);
    
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
        $totalConsultas = $totalMasculino + $totalFeminino;
    
        // Geração do PDF
        if ($tipo_relatorio == 'quantitativo') {
            $html = View::make('admin.pdf.consulta.index', compact(
                'faixaEtariaGenero',
                'totalMasculino',
                'totalFeminino',
                'totalConsultas',
                'tipo_relatorio',
                'request'
            ))->render();
        } else {
            $html = View::make('admin.pdf.consulta.index', compact('consultas', 'tipo_relatorio'))->render();
        }
    
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Consulta.pdf', 'I');
        exit;
    }
    
    public function selecionarRelatorioConsulta(){

        return view('admin._form._pdf.consulta.index');
    }//feito

    public function pdf_triagens(Request $request)
    {

        //dd($request);
        $hoje = now()->toDateString();

        $tipo_relatorio = $request->input('tipo_relatorio', 'quantitativo');

        $triagens = Triagem::join('associados', 'triagens.it_id_associado', '=', 'associados.id')
                            ->select('triagens.*', 'associados.vc_pnome as associado_pnome', 'associados.vc_unome as associado_unome', 'associados.dt_nascimento', 'associados.vc_genero');

        // Filtro por data única
        if ($request->filled('data')) {
            $triagens->whereDate('triagens.created_at', $request->data);
        }

        // Filtro por intervalo de datas
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $triagens->whereBetween('triagens.created_at', [$request->data_inicio, $request->data_fim]);
        }

        // Filtro por intervalo de meses (tem prioridade sobre o mês único)
        if ($request->filled('mes_inicio') && $request->filled('mes_fim')) {
            $ano = $request->filled('ano') ? $request->ano : now()->year;
            $mesInicio = str_pad($request->mes_inicio, 2, '0', STR_PAD_LEFT);
            $mesFim = str_pad($request->mes_fim, 2, '0', STR_PAD_LEFT);

            $dataInicio = \Carbon\Carbon::createFromFormat('Y-m-d', "$ano-$mesInicio-01")->startOfMonth();
            $dataFim = \Carbon\Carbon::createFromFormat('Y-m-d', "$ano-$mesFim-01")->endOfMonth();

            $triagens->whereBetween('triagens.created_at', [$dataInicio->toDateString(), $dataFim->toDateString()]);
        }

        // Filtro por mês único
        elseif ($request->filled('mes') && $request->filled('ano')) {
            $triagens->whereYear('triagens.created_at', $request->ano);
            $triagens->whereMonth('triagens.created_at', $request->mes);
        }

        // Filtro por ano (caso não tenha sido usado com mês)
        elseif ($request->filled('ano')) {
            $triagens->whereYear('triagens.created_at', $request->ano);
        }

        // Filtro por idade
        if ($request->filled('idade')) {
            $triagens->whereRaw('TIMESTAMPDIFF(YEAR, associados.dt_nascimento, CURDATE()) = ?', [$request->idade]);
        }

        // Filtro por intervalo de idades
        if ($request->filled('idade_min') && $request->filled('idade_max')) {
            $triagens->whereRaw('TIMESTAMPDIFF(YEAR, associados.dt_nascimento, CURDATE()) BETWEEN ? AND ?', [$request->idade_min, $request->idade_max]);
        }

        // Recupera as triagens
        $triagens = $triagens->get();

        // Adiciona idade aos associados
        $triagens = $triagens->map(function ($triagem) {
            $triagem->idade = \Carbon\Carbon::parse($triagem->dt_nascimento)->age;
            return $triagem;
        });

        // Calcula totais por faixa etária e gênero
        $faixaEtariaGenero = [
            '0-18' => ['masculino' => 0, 'feminino' => 0],
            '19-30' => ['masculino' => 0, 'feminino' => 0],
            '31-50' => ['masculino' => 0, 'feminino' => 0],
            '51+' => ['masculino' => 0, 'feminino' => 0]
        ];

        foreach ($triagens as $triagem) {
            $idade = $triagem->idade;
            $genero = strtolower($triagem->vc_genero);

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
        $totalTriagens = $totalMasculino + $totalFeminino;

        // Geração do PDF
        if ($tipo_relatorio == 'quantitativo') {
            $html = View::make('admin.pdf.triagem.index', compact(
                'faixaEtariaGenero',
                'totalMasculino',
                'totalFeminino',
                'totalTriagens',
                'tipo_relatorio',
                'request'
            ))->render();
        } else {
            $html = View::make('admin.pdf.triagem.index', compact('triagens', 'tipo_relatorio'))->render();
        }

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Triagens.pdf', 'I');
        exit;
    }
  
    public function selecionarRelatorioTriagem(){

        return view('admin._form._pdf.triagem.index');
    }//feito

    public function pdf_exames_solicitados(){
    
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();
        $fimMes = Carbon::now()->endOfMonth()->toDateString();

        $data['medicos'] = User::where('vc_tipo', 'medico')->get();
        $data['consultas'] = Consulta::all();
        $data['exames'] = Exame::all();
        $data['exame_solicitados'] = ExameSolicitado::with(['medico', 'consulta', 'exame'])
        ->whereBetween('exame_solicitados.created_at', [$inicioMes, $fimMes]) 
        ->get();

        $totalExamesSolicitados = $data['exame_solicitados']->count('id');
        $numeroExamesPendentes = $data['exame_solicitados']->where('bl_estato', 0)->count();
        $numeroExamesRealizados= $data['exame_solicitados']->where('bl_estato', 1)->count();
    
        $html = View::make('admin.pdf.exame_solicitado.index', $data, compact('totalExamesSolicitados','numeroExamesPendentes','numeroExamesRealizados'))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Exames_Solicitados.pdf', 'I');
        exit;

    }

    public function pdf_medico_consultas(){
    
        $data['medicos'] = User::where('vc_tipo', 'medico')->get();
        $data['consultas'] = Consulta::all();
        $mesAtual = now()->month;
        $anoAtual = now()->year;
        $data['medico_consultas'] = MedicoConsulta::with(['medico', 'consulta','consulta.triagem.associado'])
                                                    ->whereHas('consulta', function ($query) use ($mesAtual, $anoAtual) {
                                                        $query->whereMonth('dt_consulta', $mesAtual)
                                                            ->whereYear('dt_consulta', $anoAtual);
                                                    })
                                                    
                                                    ->get();
        $data['numero_consultas'] = MedicoConsulta::whereHas('consulta', function ($query) use ($mesAtual, $anoAtual) {
            $query->whereMonth('dt_consulta', $mesAtual)
            ->whereYear('dt_consulta', $anoAtual);
        })->count();                                            
    
        $html = View::make('admin.pdf.medico_consulta.index', $data)->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Medico_Consultas.pdf', 'I');
        exit;

    }//feito(por mês)

    public function pdfConsultaPorMedico(Request $request)
    {
        $id = $request->input('it_id_medico'); // mesma key usada no form
        $medico = User::findOrFail($id);
        $mesAtual = now()->month;
        $anoAtual = now()->year;
    
        // Carregar as consultas vinculadas ao médico específico, para o mês e ano atuais
        $data['medico_consultas'] = MedicoConsulta::with(['medico', 'consulta.triagem.associado']) // Carregar o associado relacionado à triagem da consulta
            ->where('it_id_medico', $id) // Filtrar pelo id do médico
            ->whereHas('consulta', function ($query) use ($mesAtual, $anoAtual) {
                $query->whereMonth('dt_consulta', $mesAtual)
                    ->whereYear('dt_consulta', $anoAtual);
            })
            ->get();
    
        // Contar o número de consultas vinculadas ao médico específico no mês e ano atuais
        $data['numero_consultas'] = MedicoConsulta::where('it_id_medico', $id) // Filtrar pelo id do médico
            ->whereHas('consulta', function ($query) use ($mesAtual, $anoAtual) {
                $query->whereMonth('dt_consulta', $mesAtual)
                    ->whereYear('dt_consulta', $anoAtual);
            })
            ->count(); // Contar as consultas vinculadas ao médico
    
        // Adicionar o médico aos dados
        $data['medico'] = $medico;
    
        // Gerar o HTML para o PDF
        $html = View::make('admin.pdf.medico_consulta.por_medico', $data)->render();
    
        // Gerar o PDF com o mPDF
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Consulta_Medico_{$medico->vc_pnome}_{$mesAtual}_{$anoAtual}.pdf", 'I');
        exit;
    }//feito(por mês)
    public function selecionarMedico(){
        $data['medicos'] = User::where('vc_tipo', 'medico')->get();
        $data['medico_consultas'] = MedicoConsulta::with(['medico'])->get();
            //dd(profissionais);
        return view('admin._form._pdf.medico_consulta.index', $data);
    }//feito
     
    public function pdf_escalas(){
    
        $mesAtual = now()->month;
        $anoAtual = now()->year;

        $data['turnos'] = Turno::all();
        $data['profissionais'] = User::all();
        $data['escalas'] = Escala::with(['turno', 'profissional'])
                                    ->whereMonth('dt_data', $mesAtual)
                                    ->whereYear('dt_data', $anoAtual)
                                    ->get();
    
        $html = View::make('admin.pdf.escala.index', $data,compact('mesAtual', 'anoAtual'))->render();

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Escala.pdf', 'I');
        exit;

    }//feito(por mês)

    public function pdfEscalaPorFuncionario(Request $request){
        $id = $request->input('it_id_profissional'); // mesma key usada no form
        $profissional = User::findOrFail($id);
    
        $mesAtual = now()->month;
        $anoAtual = now()->year;
    
        
        $escalas = Escala::with(['turno', 'profissional'])
                    ->where('it_id_profissional', $id)
                    ->whereMonth('dt_data', $mesAtual)
                    ->whereYear('dt_data', $anoAtual)
                    ->get();
    
        
        $numeroFaltas = $escalas->where('vc_estado', 'faltou')->count();
    
        
        $html = View::make('admin.pdf.escala.por_funcionario', compact('escalas', 'profissional', 'numeroFaltas', 'mesAtual', 'anoAtual'))->render();
    
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output("Relatorio_Escala_{$profissional->vc_pnome}_{$mesAtual}_{$anoAtual}.pdf", 'I');
        exit;
    }//feito(por mês)
    
    public function selecionarFuncionario(){
        $data['profissionais'] = User::all();
        $data['escalas'] = Escala::with(['profissional'])->get();
            //dd(profissionais);
        return view('admin._form._pdf.escala.index', $data);
    }//feito

    public function pdf_triagem_prioridade(){

        //Vamos fazer a triagem_prioridade organizar as pessoas cujas triagens estão em andamento
        //terminadas wherever
        $data['it_id_prioridade'] = Prioridade::all();
        $data['triagem_prioridades'] = TriagemPrioridade::with(['prioridade'])

        ->join('prioridades', 'triagem__prioridades.it_id_prioridade', '=', 'prioridades.id') 
        ->orderBy('prioridades.int_nivel', 'asc') 
        ->get();
    
        foreach ($data['triagem_prioridades'] as $triagemPrioridade) {
            
            $associado = Associado::where('vc_processo', $triagemPrioridade->vc_processo_paciente)->first();
    
            if ($associado) {
                $triagemPrioridade->associado_nome = $associado->vc_pnome . ' ' . $associado->vc_unome;
            } else {
                $triagemPrioridade->associado_nome = 'Paciente não encontrado';
            }
        }
    
        
        $html = View::make('admin.pdf.triagem_prioridade.index', $data)->render();
    
        
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial']);
        $mpdf->SetMargins(10, 10, 10);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Relatorio_Triagem_Prioridade.pdf', 'I');
        exit;
    }//feito

}
