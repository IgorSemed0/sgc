<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Edificio;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index()
    {
        $data['blocos'] = Bloco::all();
        $data['edificios'] = Edificio::all();
        $data['unidades'] = Unidade::with(['bloco', 'edificio'])->get();
        return view('admin.unidade.index', $data);
    }

    public function create()
    {
        $blocos = Bloco::all();
        $edificios = Edificio::all();
        return view('admin.unidade.cadastrar.index', compact('blocos', 'edificios'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tipo' => 'required|string|max:255',
                'numero' => 'required|string|max:255',
                'bloco_id' => 'required|exists:blocos,id',
                'edificio_id' => 'required|exists:edificios,id',
                'area_m2' => 'required|numeric',
                'andar' => 'nullable|integer',
                'status' => 'required|string|max:255',
            ]);

            Unidade::create($validated);

            return redirect()->route('admin.unidade.index')
                ->with('success', 'Unidade registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar unidade: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $unidade = Unidade::findOrFail($id);
        $blocos = Bloco::all();
        $edificios = Edificio::all();
        return view('admin.unidade.editar.index', compact('unidade', 'blocos', 'edificios'));
    }

    public function update(Request $request, $id)
    {
        try {
            $unidade = Unidade::findOrFail($id);

            $validated = $request->validate([
                'tipo' => 'required|string|max:255',
                'numero' => 'required|string|max:255',
                'bloco_id' => 'required|exists:blocos,id',
                'edificio_id' => 'required|exists:edificios,id',
                'area_m2' => 'required|numeric',
                'andar' => 'nullable|integer',
                'status' => 'required|string|max:255',
            ]);

            $unidade->update($validated);

            return redirect()->route('admin.unidade.index')
                ->with('success', 'Unidade atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar unidade: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            $unidade->delete();

            return redirect()->route('admin.unidade.index')
                ->with('success', 'Unidade excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.unidade.index')
                ->with('error', 'Erro ao excluir unidade: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['blocos'] = Bloco::all();
        $data['edificios'] = Edificio::all();
        $data['unidades'] = Unidade::onlyTrashed()->with(['bloco', 'edificio'])->get();
        return view('admin.unidade.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $unidade = Unidade::onlyTrashed()->findOrFail($id);
            $unidade->restore();

            return redirect()->back()->with('success', 'Unidade restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar unidade: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $unidade = Unidade::onlyTrashed()->findOrFail($id);
            $unidade->forceDelete();

            return redirect()->back()->with('success', 'Unidade excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir unidade permanentemente: ' . $e->getMessage());
        }
    }
}