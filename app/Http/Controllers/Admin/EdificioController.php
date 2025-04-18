<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edificio;
use App\Models\Bloco;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function index()
    {
        $data['blocos'] = Bloco::all();
        $data['edificios'] = Edificio::with('bloco')->get();
        return view('admin.edificio.index', $data);
    }

    public function create()
    {
        $blocos = Bloco::all();
        return view('admin.edificio.cadastrar.index', compact('blocos'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string|max:255',
                'bloco_id' => 'required|exists:blocos,id',
            ]);

            Edificio::create($validated);

            return redirect()->route('admin.edificio.index')
                ->with('success', 'Edifício registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar edifício: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $edificio = Edificio::findOrFail($id);
        $blocos = Bloco::all();
        return view('admin.edificio.editar.index', compact('edificio', 'blocos'));
    }

    public function update(Request $request, $id)
    {
        try {
            $edificio = Edificio::findOrFail($id);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string|max:255',
                'bloco_id' => 'required|exists:blocos,id',
            ]);

            $edificio->update($validated);

            return redirect()->route('admin.edificio.index')
                ->with('success', 'Edifício atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar edifício: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $edificio = Edificio::findOrFail($id);
            $edificio->delete();

            return redirect()->route('admin.edificio.index')
                ->with('success', 'Edifício excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.edificio.index')
                ->with('error', 'Erro ao excluir edifício: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['blocos'] = Bloco::all();
        $data['edificios'] = Edificio::onlyTrashed()->with('bloco')->get();
        return view('admin.edificio.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $edificio = Edificio::onlyTrashed()->findOrFail($id);
            $edificio->restore();

            return redirect()->back()->with('success', 'Edifício restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar edifício: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $edificio = Edificio::onlyTrashed()->findOrFail($id);
            $edificio->forceDelete();

            return redirect()->back()->with('success', 'Edifício excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir edifício permanentemente: ' . $e->getMessage());
        }
    }
}