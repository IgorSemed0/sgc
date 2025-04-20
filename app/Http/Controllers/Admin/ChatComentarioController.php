<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatComentario;
use App\Models\ChatPost;
use App\Models\User;
use Illuminate\Http\Request;

class ChatComentarioController extends Controller
{
    public function index()
    {
        $data['chatPosts'] = ChatPost::all();
        $data['users'] = User::all();
        $data['chatComentarios'] = ChatComentario::with(['chatPost', 'user'])->get();
        return view('admin.chat-comentario.index', $data);
    }

    public function create()
    {
        $chatPosts = ChatPost::all();
        $users = User::all();
        return view('admin.chat-comentario.cadastrar.index', compact('chatPosts', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'post_id' => 'required|exists:chat_posts,id',
                'user_id' => 'required|exists:users,id',
                'conteudo' => 'required|string',
                'data_comentario' => 'required|date',
            ]);

            ChatComentario::create($validated);

            return redirect()->route('admin.chat-comentario.index')
                ->with('success', 'Comentário de chat registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar comentário de chat: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $chatComentario = ChatComentario::findOrFail($id);
        $chatPosts = ChatPost::all();
        $users = User::all();
        return view('admin.chat-comentario.editar.index', compact('chatComentario', 'chatPosts', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $chatComentario = ChatComentario::findOrFail($id);

            $validated = $request->validate([
                'post_id' => 'required|exists:chat_posts,id',
                'user_id' => 'required|exists:users,id',
                'conteudo' => 'required|string',
                'data_comentario' => 'required|date',
            ]);

            $chatComentario->update($validated);

            return redirect()->route('admin.chat-comentario.index')
                ->with('success', 'Comentário de chat atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar comentário de chat: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $chatComentario = ChatComentario::findOrFail($id);
            $chatComentario->delete();

            return redirect()->route('admin.chat-comentario.index')
                ->with('success', 'Comentário de chat excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.chat-comentario.index')
                ->with('error', 'Erro ao excluir comentário de chat: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['chatPosts'] = ChatPost::all();
        $data['users'] = User::all();
        $data['chatComentarios'] = ChatComentario::onlyTrashed()->with(['chatPost', 'user'])->get();
        return view('admin.chat-comentario.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $chatComentario = ChatComentario::onlyTrashed()->findOrFail($id);
            $chatComentario->restore();

            return redirect()->back()->with('success', 'Comentário de chat restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar comentário de chat: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $chatComentario = ChatComentario::onlyTrashed()->findOrFail($id);
            $chatComentario->forceDelete();

            return redirect()->back()->with('success', 'Comentário de chat excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir comentário de chat permanentemente: ' . $e->getMessage());
        }
    }
}