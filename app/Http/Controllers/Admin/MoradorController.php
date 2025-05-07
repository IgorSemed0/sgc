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
        $data['inquilinos'] = Morador::where('tipo', 'inquilino')->with('unidade')->get();
        $data['unidades'] = Unidade::all();
        $data['moradores'] = Morador::with(['unidade', 'inquilino'])->get();
        return view('admin.morador.index', $data);
    }

    public function create()
    {
        $unidades = Unidade::where('status', 'disponivel')->get();
        $inquilinos = Morador::where('tipo', 'inquilino')->with('unidade')->get();
        return view('admin.morador.cadastrar.index', compact('unidades', 'inquilinos'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telefone' => 'required|string|max:20',
                'bi' => 'nullable|string|max:20',
                'cedula' => 'nullable|string|max:20',
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'unidade_id' => 'required_if:tipo,proprietario,inquilino|exists:unidades,id',
                'tipo' => 'required|in:proprietario,inquilino,dependente',
                'estado_residente' => 'required_if:tipo,proprietario|boolean',
                'dependente_de' => 'required_if:tipo,dependente|exists:moradors,id',
            ]);

            if ($request->tipo == 'dependente') {
                $inquilino = Morador::find($request->dependente_de);
                $validated['unidade_id'] = $inquilino->unidade_id;
            }

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
        $unidades = Unidade::where('status', 'disponivel')->get();
        $inquilinos = Morador::where('tipo', 'inquilino')->with('unidade')->get();
        return view('admin.morador.editar.index', compact('morador', 'unidades', 'inquilinos'));
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
                'telefone' => 'required|string|max:20',
                'bi' => 'nullable|string|max:20',
                'cedula' => 'nullable|string|max:20',
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'unidade_id' => 'required_if:tipo,proprietario,inquilino|exists:unidades,id',
                'tipo' => 'required|in:proprietario,inquilino,dependente',
                'estado_residente' => 'required_if:tipo,proprietario|boolean',
                'dependente_de' => 'required_if:tipo,dependente|exists:moradors,id',
            ]);

            if ($request->tipo == 'dependente') {
                $inquilino = Morador::find($request->dependente_de);
                $validated['unidade_id'] = $inquilino->unidade_id;
            }

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
        $data['moradores'] = Morador::onlyTrashed()->with(['unidade', 'inquilino'])->get();
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