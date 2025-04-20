<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voto;
use App\Models\Votacao;
use App\Models\OpcaoVotacao;
use App\Models\User;
use Illuminate\Http\Request;

class VotoController extends Controller
{
    public function index()
    {
        $data['votacaos'] = Votacao::all();
        $data['opcaoVotacaos'] = OpcaoVotacao::all();
        $data['users'] = User::all();
        $data['votos'] = Voto::with(['votacao', 'opcaoVotacao', 'user'])->get();
        return view('admin.voto.index', $data);
    }

    public function create()
    {
        $votacaos = Votacao::all();
        $opcaoVotacaos = OpcaoVotacao::all();
        $users = User::all();
        return view('admin.voto.cadastrar.index', compact('votacaos', 'opcaoVotacaos', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'votacao_id' => 'required|exists:votacaos,id',
                'user_id' => 'required|exists:users,id',
                'opcao_id' => 'required|exists:opcao_votacaos,id',
                'data_hora' => 'required|date',
                'hash_voto' => 'nullable|string|max:255',
            ]);

            Voto::create($validated);

            return redirect()->route('admin.voto.index')
                ->with('success', 'Voto registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar voto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $voto = Voto::findOrFail($id);
        $votacaos = Votacao::all();
        $opcaoVotacaos = OpcaoVotacao::all();
        $users = User::all();
        return view('admin.voto.editar.index', compact('voto', 'votacaos', 'opcaoVotacaos', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $voto = Voto::findOrFail($id);

            $validated = $request->validate([
                'votacao_id' => 'required|exists:votacaos,id',
                'user_id' => 'required|exists:users,id',
                'opcao_id' => 'required|exists:opcao_votacaos,id',
                'data_hora' => 'required|date',
                'hash_voto' => 'nullable|string|max:255',
            ]);

            $voto->update($validated);

            return redirect()->route('admin.voto.index')
                ->with('success', 'Voto atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar voto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $voto = Voto::findOrFail($id);
            $voto->delete();

            return redirect()->route('admin.voto.index')
                ->with('success', 'Voto excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.voto.index')
                ->with('error', 'Erro ao excluir voto: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['votacaos'] = Votacao::all();
        $data['opcaoVotacaos'] = OpcaoVotacao::all();
        $data['users'] = User::all();
        $data['votos'] = Voto::onlyTrashed()->with(['votacao', 'opcaoVotacao', 'user'])->get();
        return view('admin.voto.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $voto = Voto::onlyTrashed()->findOrFail($id);
            $voto->restore();

            return redirect()->back()->with('success', 'Voto restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar voto: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $voto = Voto::onlyTrashed()->findOrFail($id);
            $voto->forceDelete();

            return redirect()->back()->with('success', 'Voto excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir voto permanentemente: ' . $e->getMessage());
        }
    }
}