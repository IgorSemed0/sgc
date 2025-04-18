<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alocacao;
use App\Models\Especialidade;
use App\Models\Local;
use App\Models\Notificacao;
use App\Models\Subsector;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlocacaoController extends Controller
{
    public function index()
    {
        $data['especialidades'] = Especialidade::all();
        $data['locals'] = Local::all();
        $data['subsectors'] = Subsector::all();
        $data['unidades'] = Unidade::all();
        $data['alocacaos'] = Alocacao::with(['especialidade', 'local', 'subsector', 'unidade'])->get();
        return view('admin.alocacao.index', $data);
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        $locals = Local::all();
        $subsectors = Subsector::all();
        $unidades = Unidade::all();
        return view('admin.alocacao.cadastrar.index', compact('especialidades', 'locals', 'subsectors', 'unidades'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'it_id_especialidade' => 'nullable|exists:especialidades,id',
                'it_id_local' => 'required|exists:locals,id',
                'it_id_subsector' => 'required|exists:subsectors,id',
            ]);
            
            $validated['it_id_unidade'] = 1;
            
            $alocacao = Alocacao::create($validated);
            
    
            $this->registrarNotificacao('criou', $alocacao);
    
            return redirect()->route('admin.alocacao.index')
                ->with('success', 'Alocação registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar alocação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $alocacao = Alocacao::findOrFail($id);
        $especialidades = Especialidade::all();
        $locals = Local::all();
        $subsectors = Subsector::all();
        $unidades = Unidade::all();
        return view('admin.alocacao.editar.index', compact('alocacao', 'especialidades', 'locals', 'subsectors', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $alocacao = Alocacao::findOrFail($id);
    
            $validated = $request->validate([
                'it_id_especialidade' => 'nullable|exists:especialidades,id',
                'it_id_local' => 'required|exists:locals,id',
                'it_id_subsector' => 'required|exists:subsectors,id',
                'it_id_unidade' => 'required|exists:unidades,id',
            ]);
    
            $alocacao->update($validated);
    
            $this->registrarNotificacao('atualizou', $alocacao);
    
            return redirect()->route('admin.alocacao.index')
                ->with('success', 'Alocação atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar alocação: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $alocacao = Alocacao::findOrFail($id);
            $alocacao->delete();

            $this->registrarNotificacao('removeu', $alocacao);

            return redirect()->route('admin.alocacao.index')
                ->with('success', 'Alocação eliminada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.alocacao.index')
                ->with('error', 'Erro ao eliminar alocação: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['alocacaos'] = Alocacao::onlyTrashed()->with(['especialidade', 'local', 'subsector', 'unidade'])->get();
        return view('admin.alocacao.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $alocacao = Alocacao::onlyTrashed()->findOrFail($id);
            $alocacao->restore();

            $this->registrarNotificacao('restaurou', $alocacao);

            return redirect()->back()->with('success', 'Alocação restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar alocação: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $alocacao = Alocacao::onlyTrashed()->findOrFail($id);
            $alocacao->forceDelete();

            $this->registrarNotificacao('excluiu permanentemente', $alocacao);

            return redirect()->back()->with('success', 'Alocação excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir alocação permanentemente: ' . $e->getMessage());
        }
    }

    private function registrarNotificacao($acao, $alocacao)
    {
        Notificacao::create([
            'it_id_usuario' => Auth::id(),
            'txt_mensagem' => "O usuário " . Auth::user()->vc_pnome . " $acao a Alocação ID: " . $alocacao->id,
            'vc_titulo' => 'Alocação',
            'bl_estado' => false,
            'dt_envio' => now()
        ]);
    }
}