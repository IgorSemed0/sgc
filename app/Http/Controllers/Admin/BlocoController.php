<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bloco;
use App\Models\Condominio;
use Illuminate\Http\Request;

class BlocoController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['blocos'] = Bloco::all();
        return view('admin.bloco.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        return view('admin.bloco.cadastrar.index', compact('condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string|max:255',
            ]);

            Bloco::create($validated);

            return redirect()->route('admin.bloco.index')
                ->with('success', 'Bloco registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar bloco: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $bloco = Bloco::findOrFail($id);
        $condominios = Condominio::all();
        return view('admin.bloco.editar.index', compact('bloco', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $bloco = Bloco::findOrFail($id);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string|max:255',
            ]);

            $bloco->update($validated);

            return redirect()->route('admin.bloco.index')
                ->with('success', 'Bloco atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar bloco: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $bloco = Bloco::findOrFail($id);
            $bloco->delete();

            return redirect()->route('admin.bloco.index')
                ->with('success', 'Bloco excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bloco.index')
                ->with('error', 'Erro ao excluir bloco: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['blocos']  = Bloco::onlyTrashed()->with('condominio')->get();
        return view('admin.bloco.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $bloco = Bloco::onlyTrashed()->findOrFail($id);
            $bloco->restore();

            return redirect()->back()->with('success', 'Bloco restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar bloco: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $bloco = Bloco::onlyTrashed()->findOrFail($id);
            $bloco->forceDelete();

            return redirect()->back()->with('success', 'Bloco excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir bloco permanentemente: ' . $e->getMessage());
        }
    }
}