<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatPost;
use App\Models\Condominio;
use App\Models\User;
use Illuminate\Http\Request;

class ChatPostController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['users'] = User::all();
        $data['chatPosts'] = ChatPost::with(['condominio'])->get();
        return view('admin.chat-post.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        $users = User::all();
        return view('admin.chat-post.cadastrar.index', compact('condominios', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'condominio_id' => 'required|exists:condominios,id',
                'autor_id' => 'required|exists:users,id',
                'tipo_autor' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
                'data_publicacao' => 'required|date',
            ]);

            ChatPost::create($validated);

            return redirect()->route('admin.chat-post.index')
                ->with('success', 'Post de chat registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar post de chat: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $chatPost = ChatPost::findOrFail($id);
        $condominios = Condominio::all();
        $users = User::all();
        return view('admin.chat-post.editar.index', compact('chatPost', 'condominios', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $chatPost = ChatPost::findOrFail($id);

            $validated = $request->validate([
                'condominio_id' => 'required|exists:condominios,id',
                'autor_id' => 'required|exists:users,id',
                'tipo_autor' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
                'data_publicacao' => 'required|date',
            ]);

            $chatPost->update($validated);

            return redirect()->route('admin.chat-post.index')
                ->with('success', 'Post de chat atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar post de chat: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $chatPost = ChatPost::findOrFail($id);
            $chatPost->delete();

            return redirect()->route('admin.chat-post.index')
                ->with('success', 'Post de chat excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.chat-post.index')
                ->with('error', 'Erro ao excluir post de chat: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['users'] = User::all();
        $data['chatPosts'] = ChatPost::onlyTrashed()->with(['condominio'])->get();
        return view('admin.chat-post.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $chatPost = ChatPost::onlyTrashed()->findOrFail($id);
            $chatPost->restore();

            return redirect()->back()->with('success', 'Post de chat restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar post de chat: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $chatPost = ChatPost::onlyTrashed()->findOrFail($id);
            $chatPost->forceDelete();

            return redirect()->back()->with('success', 'Post de chat excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir post de chat permanentemente: ' . $e->getMessage());
        }
    }
}