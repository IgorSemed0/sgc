<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rupe;
use App\Models\Condominio;
use Illuminate\Http\Request;

class RupeController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['rupes'] = Rupe::with(['condominio'])->get();
        return view('admin.rupe.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        return view('admin.rupe.cadastrar.index', compact('condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'condominio_id' => 'required|exists:condominios,id',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'data_receita' => 'required|date',
            ]);

            Rupe::create($validated);

            return redirect()->route('admin.rupe.index')
                ->with('success', 'Receita registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar receita: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $rupe = Rupe::findOrFail($id);
        $condominios = Condominio::all();
        return view('admin.rupe.editar.index', compact('rupe', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $rupe = Rupe::findOrFail($id);

            $validated = $request->validate([
                'condominio_id' => 'required|exists:condominios,id',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'data_receita' => 'required|date',
            ]);

            $rupe->update($validated);

            return redirect()->route('admin.rupe.index')
                ->with('success', 'Receita atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar receita: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $rupe = Rupe::findOrFail($id);
            $rupe->delete();

            return redirect()->route('admin.rupe.index')
                ->with('success', 'Receita excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.rupe.index')
                ->with('error', 'Erro ao excluir receita: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['rupes'] = Rupe::onlyTrashed()->with(['condominio'])->get();
        return view('admin.rupe.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $rupe = Rupe::onlyTrashed()->findOrFail($id);
            $rupe->restore();

            return redirect()->back()->with('success', 'Receita restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar receita: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $rupe = Rupe::onlyTrashed()->findOrFail($id);
            $rupe->forceDelete();

            return redirect()->back()->with('success', 'Receita excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir receita permanentemente: ' . $e->getMessage());
        }
    }
}