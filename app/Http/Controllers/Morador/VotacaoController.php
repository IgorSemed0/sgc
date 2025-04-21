<?php

namespace App\Http\Controllers\Morador;

use App\Http\Controllers\Controller;
use App\Models\Votacao;
use App\Models\OpcaoVotacao;
use App\Models\Voto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotacaoController extends Controller
{
    public function index()
    {
        $votacaos = Votacao::with('opcaoVotacaos')->get();
        return view('morador.votacao', compact('votacaos'));
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

        Voto::create([
            'votacao_id' => $validated['votacao_id'],
            'user_id' => Auth::id(),
            'opcao_id' => $validated['opcao_id'],
            'data_hora' => now(),
        ]);

        return redirect()->back()->with('success', 'Voto registrado com sucesso.');
    }
}
