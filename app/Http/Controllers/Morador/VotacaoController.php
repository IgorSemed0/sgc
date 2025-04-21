<?php

namespace App\Http\Controllers\Morador;

use App\Http\Controllers\Controller;
use App\Models\Votacao;
use App\Models\OpcaoVotacao;
use App\Models\Voto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VotacaoController extends Controller
{
    public function index()
    {
        $votacaos = Votacao::with('opcaoVotacaos')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('morador.votacao', compact('votacaos'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $votacaos = Votacao::with('opcaoVotacaos')
            ->where('titulo', 'like', "%{$search}%")
            ->orWhere('descricao', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        $votacaos->appends(['search' => $search]);
        
        return view('morador.votacao', compact('votacaos', 'search'));
    }

    public function vote(Request $request)
    {
        $validated = $request->validate([
            'votacao_id' => 'required|exists:votacaos,id',
            'opcao_id' => 'required|exists:opcao_votacaos,id',
        ]);

        $existingVote = Voto::where('votacao_id', $validated['votacao_id'])
                            ->where('user_id', Auth::id())
                            ->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'Você já votou nesta votação.');
        }

        try {
            Voto::create([
                'votacao_id' => $validated['votacao_id'],
                'user_id' => Auth::id(),
                'opcao_id' => $validated['opcao_id'],
                'data_hora' => now(),
            ]);

            Session::flash('success', 'Voto registrado com sucesso.');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao registrar o voto. Tente novamente.');
        }
    }
}