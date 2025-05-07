<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conta;
use App\Models\Condominio;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['contas'] = Conta::all();
        return view('admin.conta.index', $data);
    }

    public function create()
    {
        $condominios = Condominio::all();
        return view('admin.conta.cadastrar.index', compact('condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
                'saldo' => 'required|numeric',
            ]);

            Conta::create($validated);

            return redirect()->route('admin.conta.index')
                ->with('success', 'Conta registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar conta: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $conta = Conta::findOrFail($id);
        $condominios = Condominio::all();
        return view('admin.conta.editar.index', compact('conta', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $conta = Conta::findOrFail($id);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
                'saldo' => 'required|numeric',
            ]);

            $conta->update($validated);

            return redirect()->route('admin.conta.index')
                ->with('success', 'Conta atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar conta: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $conta = Conta::findOrFail($id);
            $conta->delete();

            return redirect()->route('admin.conta.index')
                ->with('success', 'Conta excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.conta.index')
                ->with('error', 'Erro ao excluir conta: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['contas'] = Conta::onlyTrashed()->with(['condominio'])->get();
        return view('admin.conta.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $conta = Conta::onlyTrashed()->findOrFail($id);
            $conta->restore();

            return redirect()->back()->with('success', 'Conta restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar conta: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $conta = Conta::onlyTrashed()->findOrFail($id);
            $conta->forceDelete();

            return redirect()->back()->with('success', 'Conta excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir conta permanentemente: ' . $e->getMessage());
        }
    }
}