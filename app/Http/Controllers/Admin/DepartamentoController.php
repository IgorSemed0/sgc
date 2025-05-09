<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Condominio;
use App\Models\Unidade;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['unidades'] = Unidade::all();
        $data['departamentos'] = Departamento::all();
        return view('admin.departamento.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        $unidades = Unidade::all();
        return view('admin.departamento.cadastrar.index', compact('condominios', 'unidades'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string|max:255',
                // 'unidade_id' => 'nullable|exists:unidades,id',
            ]);

            Departamento::create($validated);

            return redirect()->route('admin.departamento.index')
                ->with('success', 'Departamento registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar departamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        $condominios = Condominio::all();
        $unidades = Unidade::all();
        return view('admin.departamento.editar.index', compact('departamento', 'condominios', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $departamento = Departamento::findOrFail($id);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string|max:255',
                // 'unidade_id' => 'nullable|exists:unidades,id',
            ]);

            $departamento->update($validated);

            return redirect()->route('admin.departamento.index')
                ->with('success', 'Departamento atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar departamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $departamento = Departamento::findOrFail($id);
            $departamento->delete();

            return redirect()->route('admin.departamento.index')
                ->with('success', 'Departamento excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.departamento.index')
                ->with('error', 'Erro ao excluir departamento: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['unidades'] = Unidade::all();
        $data['departamentos'] = Departamento::onlyTrashed()->all();
        return view('admin.departamento.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $departamento = Departamento::onlyTrashed()->findOrFail($id);
            $departamento->restore();

            return redirect()->back()->with('success', 'Departamento restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar departamento: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $departamento = Departamento::onlyTrashed()->findOrFail($id);
            $departamento->forceDelete();

            return redirect()->back()->with('success', 'Departamento excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir departamento permanentemente: ' . $e->getMessage());
        }
    }
}