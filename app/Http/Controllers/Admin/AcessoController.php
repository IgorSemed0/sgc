<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acesso;
use App\Models\Visitante;
use App\Models\Morador;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    public function index()
    {
        $data['visitantes'] = Visitante::all();
        $data['moradores'] = Morador::all();
        $data['funcionarios'] = Funcionario::all();
        $data['acessos'] = Acesso::all();
        return view('admin.acesso.index', $data);
    }

    public function create()
    {
        $visitantes = Visitante::all();
        $moradores = Morador::all();
        $funcionarios = Funcionario::all();
        return view('admin.acesso.cadastrar.index', compact('visitantes', 'moradores', 'funcionarios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'entidade_id' => 'required|integer',
                'tipo_pessoa' => 'required|string|in:Visitante,Morador,Funcionario',
                'tipo' => 'required|string|in:Entrada,Saída',
                'rf_id' => 'nullable|string|max:255',
                'observacao' => 'nullable|string|max:255',
            ]);

            $validated['data_hora'] = now();

            Acesso::create($validated);

            return redirect()->route('admin.acesso.index')
                ->with('success', 'Acesso registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar acesso: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $acesso = Acesso::findOrFail($id);
        $visitantes = Visitante::all();
        $moradores = Morador::all();
        $funcionarios = Funcionario::all();
        return view('admin.acesso.editar.index', compact('acesso', 'visitantes', 'moradores', 'funcionarios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $acesso = Acesso::findOrFail($id);

            $validated = $request->validate([
                'entidade_id' => 'required|integer',
                'tipo_pessoa' => 'required|string|in:Visitante,Morador,Funcionario',
                'tipo' => 'required|string|in:Entrada,Saída',
                'rf_id' => 'nullable|string|max:255',
                'observacao' => 'nullable|string|max:255',
            ]);

            $validated['data_hora'] = now();

            $acesso->update($validated);

            return redirect()->route('admin.acesso.index')
                ->with('success', 'Acesso atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar acesso: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $acesso = Acesso::findOrFail($id);
            $acesso->delete();

            return redirect()->route('admin.acesso.index')
                ->with('success', 'Acesso excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.acesso.index')
                ->with('error', 'Erro ao excluir acesso: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['acessos'] = Acesso::onlyTrashed()->get();
        return view('admin.acesso.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $acesso = Acesso::onlyTrashed()->findOrFail($id);
            $acesso->restore();

            return redirect()->back()->with('success', 'Acesso restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar acesso: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $acesso = Acesso::onlyTrashed()->findOrFail($id);
            $acesso->forceDelete();

            return redirect()->back()->with('success', 'Acesso excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir acesso permanentemente: ' . $e->getMessage());
        }
    }
}