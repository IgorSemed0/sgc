<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Votacao;
use App\Models\Condominio;
use Illuminate\Http\Request;

class VotacaoController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['votacaos'] = Votacao::with(['condominio'])->get();
        return view('admin.votacao.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        return view('admin.votacao.cadastrar.index', compact('condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'descricao' => 'required|string',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after:data_inicio',
                'quorum_minimo' => 'nullable|integer|min:0',
                'status' => 'required|string|max:255',
            ]);

            Votacao::create($validated);

            return redirect()->route('admin.votacao.index')
                ->with('success', 'Votação registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar votação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $votacao = Votacao::findOrFail($id);
        $condominios = Condominio::all();
        return view('admin.votacao.editar.index', compact('votacao', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $votacao = Votacao::findOrFail($id);

            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'descricao' => 'required|string',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after:data_inicio',
                'quorum_minimo' => 'nullable|integer|min:0',
                'status' => 'required|string|max:255',
            ]);

            $votacao->update($validated);

            return redirect()->route('admin.votacao.index')
                ->with('success', 'Votação atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar votação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $votacao = Votacao::findOrFail($id);
            $votacao->delete();

            return redirect()->route('admin.votacao.index')
                ->with('success', 'Votação excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.votacao.index')
                ->with('error', 'Erro ao excluir votação: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['votacaos'] = Votacao::onlyTrashed()->with(['condominio'])->get();
        return view('admin.votacao.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $votacao = Votacao::onlyTrashed()->findOrFail($id);
            $votacao->restore();

            return redirect()->back()->with('success', 'Votação restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar votação: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $votacao = Votacao::onlyTrashed()->findOrFail($id);
            $votacao->forceDelete();

            return redirect()->back()->with('success', 'Votação excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir votação permanentemente: ' . $e->getMessage());
        }
    }
}