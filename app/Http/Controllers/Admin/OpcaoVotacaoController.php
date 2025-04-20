<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpcaoVotacao;
use App\Models\Votacao;
use Illuminate\Http\Request;

class OpcaoVotacaoController extends Controller
{
    public function index()
    {
        $data['votacaos'] = Votacao::all();
        $data['opcaoVotacaos'] = OpcaoVotacao::with(['votacao'])->get();
        return view('admin.opcao-votacao.index', $data);
    }

    public function create()
    {
        $votacaos = Votacao::all();
        return view('admin.opcao-votacao.cadastrar.index', compact('votacaos'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'votacao_id' => 'required|exists:votacaos,id',
                'descricao' => 'required|string|max:255',
            ]);

            OpcaoVotacao::create($validated);

            return redirect()->route('admin.opcao-votacao.index')
                ->with('success', 'Opção de votação registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar opção de votação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $opcaoVotacao = OpcaoVotacao::findOrFail($id);
        $votacaos = Votacao::all();
        return view('admin.opcao-votacao.editar.index', compact('opcaoVotacao', 'votacaos'));
    }

    public function update(Request $request, $id)
    {
        try {
            $opcaoVotacao = OpcaoVotacao::findOrFail($id);

            $validated = $request->validate([
                'votacao_id' => 'required|exists:votacaos,id',
                'descricao' => 'required|string|max:255',
            ]);

            $opcaoVotacao->update($validated);

            return redirect()->route('admin.opcao-votacao.index')
                ->with('success', 'Opção de votação atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar opção de votação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $opcaoVotacao = OpcaoVotacao::findOrFail($id);
            $opcaoVotacao->delete();

            return redirect()->route('admin.opcao-votacao.index')
                ->with('success', 'Opção de votação excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.opcao-votacao.index')
                ->with('error', 'Erro ao excluir opção de votação: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['votacaos'] = V Dr::all();
        $data['opcaoVotacaos'] = OpcaoVotacao::onlyTrashed()->with(['votacao'])->get();
        return view('admin.opcao-votacao.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $opcaoVotacao = OpcaoVotacao::onlyTrashed()->findOrFail($id);
            $opcaoVotacao->restore();

            return redirect()->back()->with('success', 'Opção de votação restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar opção de votação: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $opcaoVotacao = OpcaoVotacao::onlyTrashed()->findOrFail($id);
            $opcaoVotacao->forceDelete();

            return redirect()->back()->with('success', 'Opção de votação excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir opção de votação permanentemente: ' . $e->getMessage());
        }
    }
}