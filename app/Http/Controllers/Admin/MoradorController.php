<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Morador;
use App\Models\Unidade;
use Illuminate\Http\Request;

class MoradorController extends Controller
{
    public function index()
    {
        $data['unidades'] = Unidade::all();
        $data['moradores'] = Morador::with(['unidade'])->get();
        return view('admin.morador.index', $data);
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('admin.morador.cadastrar.index', compact('unidades'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'username' => 'nullable|string|max:255',
                'telefone' => 'required|string|max:20',
                'bi' => 'required|string|max:20',
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'unidade_id' => 'required|exists:unidades,id',
                'tipo' => 'required|string|max:255',
                'rf_id' => 'required|string|max:255',
                'processo' => 'required|string|max:255',
            ]);

            Morador::create($validated);

            return redirect()->route('admin.morador.index')
                ->with('success', 'Morador registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar morador: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $morador = Morador::findOrFail($id);
        $unidades = Unidade::all();
        return view('admin.morador.editar.index', compact('morador', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $morador = Morador::findOrFail($id);

            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'username' => 'nullable|string|max:255',
                'telefone' => 'required|string|max:20',
                'bi' => 'required|string|max:20',
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'unidade_id' => 'required|exists:unidades,id',
                'tipo' => 'required|string|max:255',
                'rf_id' => 'required|string|max:255',
                'processo' => 'required|string|max:255',
            ]);

            $morador->update($validated);

            return redirect()->route('admin.morador.index')
                ->with('success', 'Morador atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar morador: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $morador = Morador::findOrFail($id);
            $morador->delete();

            return redirect()->route('admin.morador.index')
                ->with('success', 'Morador excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.morador.index')
                ->with('error', 'Erro ao excluir morador: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['unidades'] = Unidade::all();
        $data['moradores'] = Morador::onlyTrashed()->with(['unidade'])->get();
        return view('admin.morador.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $morador = Morador::onlyTrashed()->findOrFail($id);
            $morador->restore();

            return redirect()->back()->with('success', 'Morador restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar morador: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $morador = Morador::onlyTrashed()->findOrFail($id);
            $morador->forceDelete();

            return redirect()->back()->with('success', 'Morador excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir morador permanentemente: ' . $e->getMessage());
        }
    }
}