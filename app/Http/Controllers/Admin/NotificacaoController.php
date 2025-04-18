<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notificacao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $data['notificacoes'] = Notificacao::all(); 

        $data['usuarios'] = User::all();
        return view('admin.notificacao.index', $data);
    }

    public function show($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);
            
            // Marcar como lida
            $notificacao->update(['bl_estado' => true]);

            return view('admin.notificacao.show.index', compact('notificacao'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.notificacao.index')->with('error', 'Notificação não encontrada.');
        }
    }

    public function create()
    {
        $usuarios = User::all();
        return view('admin.notificacao.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'it_id_usuario' => 'required|exists:users,id',
            'vc_titulo' => 'required|string|max:255',
            'txt_mensagem' => 'required|string',
            'prescricao_id' => 'nullable|exists:prescricoes,id', // Adicionado para vincular notificações a prescrições
            'bl_estado' => 'boolean',
            'dt_envio' => 'nullable|date',
        ]);
        $validated['it_id_unidade'] = 1;

        try {
            Notificacao::create($request->all());
            return redirect()->route('admin.notificacao.index')->with('success', 'Notificação criada com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('admin.notificacao.index')->with('error', 'Erro ao criar a notificação.');
        }
    }

    public function edit($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);
            $usuarios = User::all();
            return view('admin.notificacao.edit', compact('notificacao', 'usuarios'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.notificacao.index')->with('error', 'Notificação não encontrada.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'it_id_usuario' => 'required|exists:users,id',
            'vc_titulo' => 'required|string|max:255',
            'txt_mensagem' => 'required|string',
            'prescricao_id' => 'nullable|exists:prescricoes,id',
            'bl_estado' => 'boolean',
            'dt_envio' => 'nullable|date',
        ]);

        try {
            $notificacao = Notificacao::findOrFail($id);
            $notificacao->update($request->all());
            return redirect()->route('admin.notificacao.index')->with('success', 'Notificação atualizada com sucesso.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.notificacao.index')->with('error', 'Notificação não encontrada.');
        } catch (Exception $e) {
            return redirect()->route('admin.notificacao.index')->with('error', 'Erro ao atualizar a notificação.');
        }
    }

    public function destroy($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);
            $notificacao->delete();
            return redirect()->route('admin.notificacao.index')->with('success', 'Notificação deletada com sucesso.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.notificacao.index')->with('error', 'Notificação não encontrada.');
        }
    }

    public function trash()
    {
        $data['notificacoes'] = Notificacao::onlyTrashed()->get();
        $data['usuarios'] = User::all();
        return view('admin.notificacao.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $notificacao = Notificacao::withTrashed()->findOrFail($id);
            $notificacao->restore();
            return redirect()->back()->with('success', 'Notificação restaurada com sucesso.');
        } catch (ModelNotFoundException $e) {
            return view('admin.notificacao.index')->with('error', 'Notificação não encontrada.');
        }
    }

    public function purge($id)
    {
        try {
            $notificacao = Notificacao::withTrashed()->findOrFail($id);
            $notificacao->forceDelete();
            return redirect()->back()->with('success', 'Notificação excluída permanentemente.');
        } catch (ModelNotFoundException $e) {
            return view('admin.notificacao.lixeira.index')->with('error', 'Notificação não encontrada.');
        }
    }

    public function markAsRead($id)
    {
        try {
            $notificacao = Notificacao::findOrFail($id);
            $notificacao->update(['bl_estado' => true]);

            return response()->json(['success' => true]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Notificação não encontrada.'], 404);
        }
    }
}
