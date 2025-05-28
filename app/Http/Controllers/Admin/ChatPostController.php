<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatPost;
use App\Models\Condominio;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ChatPostController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['users'] = User::all();
        $data['chatPosts'] = ChatPost::all();
        
        // dd($data['chatPosts']);
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
            $autor = Auth::user()->id;
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
            ]);
            $validated['tipo_autor'] = "admin";
            $validated['data_publicacao'] = Carbon::now();
            $validated['autor_id'] = $autor;

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

            $autor = Auth::user()->id;

            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'conteudo' => 'required|string',
            ]);

            $validated['tipo_autor'] = "admin";
            $validated['data_publicacao'] = Carbon::now();
            $validated['autor_id'] = $autor;

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
        $data['chatPosts'] = ChatPost::onlyTrashed()->all();
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

    public function feed(Request $request)
    {
        try {
            $posts = ChatPost::with(['chatComentarios.user', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(9);
        } catch (\Exception $e) {
            $posts = collect([]);
        }
            
        return view('admin.chat-post.feed', compact('posts'));
    }
    
    public function feedSearch(Request $request)
    {
        $search = $request->input('search');
        
        try {
            $posts = ChatPost::with(['chatComentarios.user', 'user'])
                ->where('titulo', 'like', "%{$search}%")
                ->orWhere('conteudo', 'like', "%{$search}%")
                ->orderBy('created_at', 'desc')
                ->paginate(9);
                
            $posts->appends(['search' => $search]);
        } catch (\Exception $e) {
            $posts = collect([]);
        }
        
        return view('admin.chat-post.feed', compact('posts', 'search'));
    }
}