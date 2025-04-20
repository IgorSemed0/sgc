<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Despesa;
use App\Models\Condominio;
use Illuminate\Http\Request;

class DespesaController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['despesas'] = Despesa::with(['condominio'])->get();
        return view('admin.despesa.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        return view('admin.despesa.cadastrar.index', compact('condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'condominio_id' => 'required|exists:condominios,id',
                'categoria' => 'required|string|max:255',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'data_despesa' => 'required|date',
            ]);

            Despesa::create($validated);

            return redirect()->route('admin.despesa.index')
                ->with('success', 'Despesa registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar despesa: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $despesa = Despesa::findOrFail($id);
        $condominios = Condominio::all();
        return view('admin.despesa.editar.index', compact('despesa', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $despesa = Despesa::findOrFail($id);

            $validated = $request->validate([
                'condominio_id' => 'required|exists:condominios,id',
                'categoria' => 'required|string|max:255',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'data_despesa' => 'required|date',
            ]);

            $despesa->update($validated);

            return redirect()->route('admin.despesa.index')
                ->with('success', 'Despesa atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar despesa: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $despesa = Despesa::findOrFail($id);
            $despesa->delete();

            return redirect()->route('admin.despesa.index')
                ->with('success', 'Despesa excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.despesa.index')
                ->with('error', 'Erro ao excluir despesa: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['despesas'] = Despesa::onlyTrashed()->with(['condominio'])->get();
        return view('admin.despesa.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $despesa = Despesa::onlyTrashed()->findOrFail($id);
            $despesa->restore();

            return redirect()->back()->with('success', 'Despesa restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar despesa: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $despesa = Despesa::onlyTrashed()->findOrFail($id);
            $despesa->forceDelete();

            return redirect()->back()->with('success', 'Despesa excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir despesa permanentemente: ' . $e->getMessage());
        }
    }
}