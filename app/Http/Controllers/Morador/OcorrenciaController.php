<?php

namespace App\Http\Controllers\Morador;

use App\Http\Controllers\Controller;
use App\Models\Ocorrencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OcorrenciaController extends Controller
{
    public function index()
    {
        $data['ocorrencias'] = Ocorrencia::where('user_id', Auth::id())->get();
        return view('morador.ocorrencia.index', $data);
    }

    public function create()
    {
        return view('morador.ocorrencia.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'descricao' => 'required|string',
            ]);

            $validated['user_id'] = Auth::id();

            Ocorrencia::create($validated);

            return redirect()->route('morador.ocorrencia.index')
                ->with('success', 'Ocorrência registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar ocorrência: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $data['ocorrencia'] = Ocorrencia::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        return view('morador.ocorrencia.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $ocorrencia = Ocorrencia::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validate([
                'descricao' => 'required|string',
            ]);

            $ocorrencia->update($validated);

            return redirect()->route('morador.ocorrencia.index')
                ->with('success', 'Ocorrência atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar ocorrência: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $ocorrencia = Ocorrencia::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
                
            $ocorrencia->delete();
            
            return redirect()->route('morador.ocorrencia.index')
                ->with('success', 'Ocorrência excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('morador.ocorrencia.index')
                ->with('error', 'Erro ao excluir ocorrência: ' . $e->getMessage());
        }
    }
}