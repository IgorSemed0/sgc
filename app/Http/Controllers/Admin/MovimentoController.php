<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movimento;
use App\Models\Conta;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    public function index()
    {
        $data['contas'] = Conta::all();
        $data['movimentos'] = Movimento::with(['conta'])->get();
        return view('admin.movimento.index', $data);
    }

    public function create()
    {
        $contas = Conta::all();
        return view('admin.movimento.cadastrar.index', compact('contas'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'conta_id' => 'required|exists:contas,id',
                'tipo' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'descricao' => 'nullable|string|max:255',
                'data_movimento' => 'required|date',
            ]);

            Movimento::create($validated);

            return redirect()->route('admin.movimento.index')
                ->with('success', 'Movimento registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar movimento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $movimento = Movimento::findOrFail($id);
        $contas = Conta::all();
        return view('admin.movimento.editar.index', compact('movimento', 'contas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $movimento = Movimento::findOrFail($id);

            $validated = $request->validate([
                'conta_id' => 'required|exists:contas,id',
                'tipo' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
                'descricao' => 'nullable|string|max:255',
                'data_movimento' => 'required|date',
            ]);

            $movimento->update($validated);

            return redirect()->route('admin.movimento.index')
                ->with('success', 'Movimento atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar movimento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $movimento = Movimento::findOrFail($id);
            $movimento->delete();

            return redirect()->route('admin.movimento.index')
                ->with('success', 'Movimento excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.movimento.index')
                ->with('error', 'Erro ao excluir movimento: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['contas'] = Conta::all();
        $data['movimentos'] = Movimento::onlyTrashed()->with(['conta'])->get();
        return view('admin.movimento.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $movimento = Movimento::onlyTrashed()->findOrFail($id);
            $movimento->restore();

            return redirect()->back()->with('success', 'Movimento restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar movimento: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $movimento = Movimento::onlyTrashed()->findOrFail($id);
            $movimento->forceDelete();

            return redirect()->back()->with('success', 'Movimento excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir movimento permanentemente: ' . $e->getMessage());
        }
    }
}