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
        try {
            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telefone' => 'required|string|max:20',
                'bi' => 'required|string|max:20',
                'dt_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'tipo' => 'required|in:Particular,Geral',
                'cargo' => 'required_if:tipo,Geral|string|max:255|nullable',
                'unidade_id' => 'required_if:tipo,Geral|exists:unidades,id|nullable',
                'departamento_id' => 'required|exists:departamentos,id',
            ]);

            Funcionario::create($validated);

            return redirect()->route('admin.funcionario.index')
                ->with('success', 'Funcionário registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar funcionário: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $departamentos = Departamento::all();
        $condominios = Condominio::all();
        $unidades = Unidade::where('status', 'disponivel')->get();
        return view('admin.funcionario.editar.index', compact('funcionario', 'departamentos', 'condominios', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $funcionario = Funcionario::findOrFail($id);

            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telefone' => 'required|string|max:20',
                'bi' => 'required|string|max:20',
                'dt_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'tipo' => 'required|in:Particular,Geral',
                'cargo' => 'required_if:tipo,Geral|string|max:255|nullable',
                'unidade_id' => 'required_if:tipo,Geral|exists:unidades,id|nullable',
                'departamento_id' => 'required|exists:departamentos,id',
            ]);

            $funcionario->update($validated);

            return redirect()->route('admin.funcionario.index')
                ->with('success', 'Funcionário atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar funcionário: ' . $e->getMessage())
                ->withInput();
        }
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