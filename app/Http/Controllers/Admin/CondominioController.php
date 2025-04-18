<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Condominio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CondominioController extends Controller
{
    public function index()
    {
        $condominios = Condominio::all();
        return view('admin.condominio.index', compact('condominios'));
    }

    public function create()
    {
        return view('admin.condominio.cadastrar.index');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'bairro' => 'nullable|string|max:255',
                'cidade' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'telefone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
            ]);

            Condominio::create($validated);

            return redirect()->route('admin.condominio.index')
                ->with('success', 'Condomínio registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar condomínio: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $condominio = Condominio::findOrFail($id);
        return view('admin.condominio.editar.index', compact('condominio'));
    }

    public function update(Request $request, $id)
    {
        try {
            $condominio = Condominio::findOrFail($id);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'bairro' => 'nullable|string|max:255',
                'cidade' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'telefone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
            ]);

            $condominio->update($validated);

            return redirect()->route('admin.condominio.index')
                ->with('success', 'Condomínio atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar condomínio: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $condominio = Condominio::findOrFail($id);
            $condominio->delete();

            return redirect()->route('admin.condominio.index')
                ->with('success', 'Condomínio excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.condominio.index')
                ->with('error', 'Erro ao excluir condomínio: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $condominios = Condominio::onlyTrashed()->get();
        return view('admin.condominio.lixeira.index', compact('condominios'));
    }

    public function restore($id)
    {
        try {
            $condominio = Condominio::onlyTrashed()->findOrFail($id);
            $condominio->restore();

            return redirect()->back()->with('success', 'Condomínio restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar condomínio: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $condominio = Condominio::onlyTrashed()->findOrFail($id);
            $condominio->forceDelete();

            return redirect()->back()->with('success', 'Condomínio excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir condomínio permanentemente: ' . $e->getMessage());
        }
    }
}