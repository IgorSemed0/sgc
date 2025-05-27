<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Departamento;
use App\Models\Condominio;
use App\Models\Unidade;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $data['unidades'] = Unidade::all();
        $data['departamentos'] = Departamento::all();
        $data['condominios'] = Condominio::all();
        $data['funcionarios'] = Funcionario::with(['departamento', 'unidade'])->get();
        return view('admin.funcionario.index', $data);
    }

    public function create()
    {
        $departamentos = Departamento::all();
        $condominios = Condominio::all();
        $unidades = Unidade::where('status', 'disponivel')->get();
        return view('admin.funcionario.cadastrar.index', compact('departamentos', 'condominios', 'unidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'nomes_meio' => 'nullable|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'email' => 'required|email|unique:funcionarios,email',
            'username' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:255',
            'bi' => 'required|string|max:255',
            'dt_nascimento' => 'required|date',
            'sexo' => 'required|in:Masculino,Feminino,Outro',
            'tipo' => 'required|in:Particular,Geral',
            'cargo' => 'required_if:tipo,Particular|nullable|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
            'unidade_id' => 'required_if:tipo,Particular|nullable|exists:unidades,id',
        ]);
    
        if ($validated['tipo'] === 'Geral') {
            $validated['unidade_id'] = null;
            $validated['cargo'] = null;
        }
    
        Funcionario::create($validated);
    
        return redirect()->route('admin.funcionarios.index')->with('success', 'Funcionário criado com sucesso!');
    }


    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $departamentos = Departamento::all();
        $condominios = Condominio::all();
        $unidades = Unidade::where('status', 'disponivel')->get();
        return view('admin.funcionario.editar.index', compact('funcionario', 'departamentos', 'condominios', 'unidades'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'nomes_meio' => 'nullable|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'email' => 'required|email|unique:funcionarios,email,' . $funcionario->id,
            'username' => 'nullable|string|max:255',
            'telefone' => 'required|string|max:255',
            'bi' => 'required|string|max:255',
            'dt_nascimento' => 'required|date',
            'sexo' => 'required|in:Masculino,Feminino,Outro',
            'tipo' => 'required|in:Particular,Geral',
            'cargo' => 'required_if:tipo,Particular|nullable|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
            'unidade_id' => 'required_if:tipo,Particular|nullable|exists:unidades,id',
        ]);
    
        if ($validated['tipo'] === 'Geral') {
            $validated['unidade_id'] = null;
            $validated['cargo'] = null;
        }
    
        $funcionario->update($validated);
    
        return redirect()->route('admin.funcionarios.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $funcionario = Funcionario::findOrFail($id);
            $funcionario->delete();

            return redirect()->route('admin.funcionario.index')
                ->with('success', 'Funcionário excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.funcionario.index')
                ->with('error', 'Erro ao excluir funcionário: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['unidades'] = Unidade::all();
        $data['departamentos'] = Departamento::all();
        $data['condominios'] = Condominio::all();
        $data['funcionarios'] = Funcionario::onlyTrashed()->with(['departamento', 'unidade'])->get();
        return view('admin.funcionario.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $funcionario = Funcionario::onlyTrashed()->findOrFail($id);
            $funcionario->restore();

            return redirect()->back()->with('success', 'Funcionário restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar funcionário: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $funcionario = Funcionario::onlyTrashed()->findOrFail($id);
            $funcionario->forceDelete();

            return redirect()->back()->with('success', 'Funcionário excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir funcionário permanentemente: ' . $e->getMessage());
        }
    }
}