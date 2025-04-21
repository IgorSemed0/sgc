<?php
namespace App\Http\Controllers\Morador;

use App\Http\Controllers\Controller;
use App\Models\ChatPost;
use App\Models\ChatComentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeedController extends Controller
{

    public function index(Request $request)
    {
        $posts = ChatPost::with(['chatComentarios.user', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        return view('morador.feed', compact('posts'));
    }


    public function comment(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:chat_posts,id',
            'conteudo' => 'required|string|max:500',
        ]);

        try {
            ChatComentario::create([
                'post_id' => $validated['post_id'],
                'user_id' => Auth::id(),
                'conteudo' => $validated['conteudo'],
                'data_comentario' => now(),
            ]);

            Session::flash('success', 'Comentário adicionado com sucesso.');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao adicionar comentário. Por favor, tente novamente.');
        }
    }
    
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $posts = ChatPost::with(['chatComentarios.user', 'user'])
            ->where('titulo', 'like', "%{$search}%")
            ->orWhere('conteudo', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        $posts->appends(['search' => $search]);
        
        return view('morador.feed', compact('posts', 'search'));
    }
}