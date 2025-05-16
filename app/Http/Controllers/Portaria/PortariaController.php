<?php

namespace App\Http\Controllers\Portaria;

use App\Http\Controllers\Controller;
use App\Models\Morador;
use App\Models\Funcionario;
use App\Models\Visitante;
use App\Models\Acesso;
use App\Models\Unidade;
use App\Models\Condominio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PortariaController extends Controller
{
    public function index()
    {
        $acessos = Acesso::orderBy('data_hora', 'desc')
                        ->take(10)
                        ->get();

        $unidades = Unidade::all();
        $condominios = Condominio::all();
        
        return view('portaria.index', compact('acessos', 'unidades', 'condominios'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'bi' => 'required|string',
        ]);

        $bi = $validated['bi'];

        $morador = Morador::where('bi', $bi)->first();
        if ($morador) {
            return response()->json(['type' => 'morador', 'data' => $morador]);
        }

        $funcionario = Funcionario::where('bi', $bi)->first();
        if ($funcionario) {
            return response()->json(['type' => 'funcionario', 'data' => $funcionario]);
        }

        $visitante = Visitante::where('bi', $bi)->first();
        if ($visitante) {
            return response()->json(['type' => 'visitante', 'data' => $visitante]);
        }

        return response()->json(['type' => 'not_found', 'message' => 'Pessoa não encontrada. Registre como novo visitante.']);
    }

    public function searchMorador(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $name = $validated['name'];

        $moradores = Morador::where(function($query) {
                $query->where('tipo', 'Morador')
                      ->orWhere('tipo', 'Dependente');
            })
            ->where(function($query) use ($name) {
                $query->where('primeiro_nome', 'like', "%{$name}%")
                      ->orWhere('nomes_meio', 'like', "%{$name}%")
                      ->orWhere('ultimo_nome', 'like', "%{$name}%");
            })
            ->with(['unidade.bloco'])
            ->take(10)
            ->get();

        $moradores = $moradores->map(function($morador) {
            if ($morador->unidade) {
                $blocoName = $morador->unidade->bloco ? $morador->unidade->bloco->nome : 'N/A';
                $morador->unidade_info = "U{$morador->unidade->numero} - {$blocoName}";
            } else {
                $morador->unidade_info = 'Não associado';
            }
            return $morador;
        });

        return response()->json(['moradores' => $moradores]);
    }

    public function registerAccess(Request $request)
    {
        $validated = $request->validate([
            'entidade_id' => 'required|integer',
            'tipo_pessoa' => 'required|in:morador,funcionario,visitante',
            'tipo' => 'required|in:Entrada,Saida',
            'observacao' => 'nullable|string',
        ]);
        
        $validated['data_hora'] = now();

        try {
            Acesso::create([
                'entidade_id' => $validated['entidade_id'],
                'tipo_pessoa' => $validated['tipo_pessoa'],
                'tipo' => $validated['tipo'],
                'data_hora' => $validated['data_hora'],
                'observacao' => $validated['observacao'],
            ]);

            return redirect()->route('portaria.index')->with('success', 'Acesso registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao registrar acesso: ' . $e->getMessage());
        }
    }

    public function storeVisitante(Request $request)
    {
        $validated = $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'nomes_meio' => 'nullable|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'bi' => 'required|string|max:255|unique:visitantes',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:255',
            'motivo_visita' => 'required|string',
            'unidade_id' => 'nullable|exists:unidades,id',
        ]);

        try {
            $visitante = Visitante::create($validated);

            Acesso::create([
                'entidade_id' => $visitante->id,
                'tipo_pessoa' => 'visitante',
                'tipo' => 'Entrada',
                'data_hora' => now(),
                'observacao' => 'Novo visitante registrado.',
            ]);

            return redirect()->route('portaria.index')->with('success', 'Visitante registrado e acesso de entrada criado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao registrar visitante: ' . $e->getMessage())->withInput();
        }
    }

    public function confirmVisit(Request $request)
    {
        $validated = $request->validate([
            'morador_id' => 'required|integer|exists:moradors,id',
        ]);

        try {
            // You can add any additional logic here to record that the visit was confirmed
            // For example, you might want to add an entry to a visits log or update a status

            return response()->json(['success' => true, 'message' => 'Visita confirmada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}