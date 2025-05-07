<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EspacoComum;
use App\Models\Condominio;
use Illuminate\Http\Request;

class EspacoComumController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['espacoComums'] = EspacoComum::with(['condominio'])->get();
        return view('admin.espaco-comum.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        return view('admin.espaco-comum.cadastrar.index', compact('condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
                'capacidade' => 'required|integer|min:1',
                'regras' => 'nullable|string',
            ]);

            EspacoComum::create($validated);

            return redirect()->route('admin.espaco-comum.index')
                ->with('success', 'Espaço comum registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar espaço comum: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $espacoComum = EspacoComum::findOrFail($id);
        $condominios = Condominio::all();
        return view('admin.espaco-comum.editar.index', compact('espacoComum', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $espacoComum = EspacoComum::findOrFail($id);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
                'capacidade' => 'required|integer|min:1',
                'regras' => 'nullable|string',
            ]);

            $espacoComum->update($validated);

            return redirect()->route('admin.espaco-comum.index')
                ->with('success', 'Espaço comum atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar espaço comum: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $espacoComum = EspacoComum::findOrFail($id);
            $espacoComum->delete();

            return redirect()->route('admin.espaco-comum.index')
                ->with('success', 'Espaço comum excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.espaco-comum.index')
                ->with('error', 'Erro ao excluir espaço comum: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['espacoComums'] = EspacoComum::onlyTrashed()->with(['condominio'])->get();
        return view('admin.espaco-comum.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $espacoComum = EspacoComum::onlyTrashed()->findOrFail($id);
            $espacoComum->restore();

            return redirect()->back()->with('success', 'Espaço comum restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar espaço comum: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $espacoComum = EspacoComum::onlyTrashed()->findOrFail($id);
            $espacoComum->forceDelete();

            return redirect()->back()->with('success', 'Espaço comum excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir espaço comum permanentemente: ' . $e->getMessage());
        }
    }
}