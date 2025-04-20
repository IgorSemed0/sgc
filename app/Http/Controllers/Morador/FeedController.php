<?php

namespace App\Http\Controllers\Morador;

use App\Http\Controllers\Controller;
use App\Models\ChatPost;
use App\Models\ChatComentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
        $posts = ChatPost::with('chatComentarios')->get();
        return view('morador.feed', compact('posts'));
    }

    public function comment(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:chat_posts,id',
            'conteudo' => 'required|string',
        ]);

        ChatComentario::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'conteudo' => $validated['conteudo'],
            'data_comentario' => now(),
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso.');
    }
}
