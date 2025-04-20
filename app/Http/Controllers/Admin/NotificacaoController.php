<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    public function index()
    {
        $data['users'] = User::all();
        $data['notificacaos'] = Notificacao::with(['user'])->get();
        return view('admin.notificacao.index', $data);
    }

    public function create()
    {
        $users = User::all();
        return view('admin.notificacao.cadastrar.index', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tipo' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
                'data_hora' => 'required|date',
                'lida' => 'boolean',
            ]);

            Notificacao::create($validated);

            return redirect()->route('admin.notificacao.index')
                ->with('success', 'Notificação registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar notificação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $notificacao = Notificacao::findOrFail($id);
        $users = User::all();
        return view('admin.notificacao.editar.index', compact('notificacao', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tipo' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
                'data_hora' => 'required|date',
                'lida' => 'boolean',
            ]);

            $notificacao->update($validated);

            return redirect()->route('admin.notificacao.index')
                ->with('success', 'Notificação atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar notificação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);
            $notificacao->delete();

            return redirect()->route('admin.notificacao.index')
                ->with('success', 'Notificação excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.notificacao.index')
                ->with('error', 'Erro ao excluir notificação: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['users'] = User::all();
        $data['notificacaos'] = Notificacao::onlyTrashed()->with(['user'])->get();
        return view('admin.notificacao.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $notificacao = Notificacao::onlyTrashed()->findOrFail($id);
            $notificacao->restore();

            return redirect()->back()->with('success', 'Notificação restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar notificação: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $notificacao = Notificacao::onlyTrashed()->findOrFail($id);
            $notificacao->forceDelete();

            return redirect()->back()->with('success', 'Notificação excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir notificação permanentemente: ' . $e->getMessage());
        }
    }
}