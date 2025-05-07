<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitante;
use App\Models\Unidade;
use App\Models\Condominio;
use Illuminate\Http\Request;

class VisitanteController extends Controller
{
    public function index()
    {
        $data['unidades'] = Unidade::all();
        $data['condominios'] = Condominio::all();
        $data['visitantes'] = Visitante::with(['unidade', 'condominio'])->get();
        return view('admin.visitante.index', $data);
    }

    public function create()
    {
        $unidades = Unidade::all();
        $condominios = Condominio::all();
        return view('admin.visitante.cadastrar.index', compact('unidades', 'condominios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'bi' => 'required|string|max:20|unique:visitantes,bi',
                'email' => 'required|email|max:255|unique:visitantes,email',
                'telefone' => 'required|string|max:20',
                'motivo_visita' => 'required|string|max:255',
                'unidade_id' => 'required|exists:unidades,id',
                //'condominio_id' => 'required|exists:condominios,id',
            ]);

            Visitante::create($validated);

            return redirect()->route('admin.visitante.index')
                ->with('success', 'Visitante registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar visitante: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $visitante = Visitante::findOrFail($id);
        $unidades = Unidade::all();
        $condominios = Condominio::all();
        return view('admin.visitante.editar.index', compact('visitante', 'unidades', 'condominios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $visitante = Visitante::findOrFail($id);

            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'bi' => 'required|string|max:20|unique:visitantes,bi,' . $id,
                'email' => 'required|email|max:255|unique:visitantes,email,' . $id,
                'telefone' => 'required|string|max:20',
                'motivo_visita' => 'required|string|max:255',
                'unidade_id' => 'required|exists:unidades,id',
                //'condominio_id' => 'required|exists:condominios,id',
            ]);

            $visitante->update($validated);

            return redirect()->route('admin.visitante.index')
                ->with('success', 'Visitante atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar visitante: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $visitante = Visitante::findOrFail($id);
            $visitante->delete();

            return redirect()->route('admin.visitante.index')
                ->with('success', 'Visitante excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.visitante.index')
                ->with('error', 'Erro ao excluir visitante: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['unidades'] = Unidade::all();
        $data['condominios'] = Condominio::all();
        $data['visitantes'] = Visitante::onlyTrashed()->with(['unidade', 'condominio'])->get();
        return view('admin.visitante.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $visitante = Visitante::onlyTrashed()->findOrFail($id);
            $visitante->restore();

            return redirect()->back()->with('success', 'Visitante restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar visitante: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $visitante = Visitante::onlyTrashed()->findOrFail($id);
            $visitante->forceDelete();

            return redirect()->back()->with('success', 'Visitante excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir visitante permanentemente: ' . $e->getMessage());
        }
    }
}