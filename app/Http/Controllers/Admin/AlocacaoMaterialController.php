<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alocacao;
use App\Models\AlocacaoMaterial;
use App\Models\Consulta;
use App\Models\Notificacao;
use App\Models\Produto;
use App\Models\Triagem;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlocacaoMaterialController extends Controller
{
    public function index()
    {
        $data['triagems'] = Triagem::all();
        $data['consultas'] = Consulta::all();
        $data['produtos'] = Produto::all();
        $data['alocacaos'] = Alocacao::all();
        $data['unidades'] = Unidade::all();
        $data['alocacao_materials'] = AlocacaoMaterial::with(['triagem', 'consulta', 'produto', 'alocacao', 'unidade'])->get();
        return view('admin.alocacao_material.index', $data);
    }

    public function create()
    {
        $triagems = Triagem::all();
        $consultas = Consulta::all();
        $produtos = Produto::all();
        $alocacaos = Alocacao::all();
        $unidades = Unidade::all();
        return view('admin.alocacao_material.cadastrar.index', compact('triagems', 'consultas', 'produtos', 'alocacaos', 'unidades'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'it_id_triagem' => 'nullable|exists:triagems,id',
                'it_id_consulta' => 'nullable|exists:consultas,id',
                'it_id_produto' => 'required|exists:produtos,id',
                'it_id_alocacao' => 'required|exists:alocacaos,id',
                'it_quantidade' => 'required|integer|min:1',
                'vc_unidade' => 'required|string|max:255',
                'vc_motivo' => 'required|string|max:255',
            ]);
            $validated['it_id_unidade'] = 1;
            $alocacaoMaterial = AlocacaoMaterial::create($validated);

            $this->registrarNotificacao('criou', $alocacaoMaterial);

            return redirect()->route('admin.alocacao_material.index')
                ->with('success', 'Material alocado registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar material alocado: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $alocacao_material = AlocacaoMaterial::findOrFail($id);
        $triagems = Triagem::all();
        $consultas = Consulta::all();
        $produtos = Produto::all();
        $alocacaos = Alocacao::all();
        $unidades = Unidade::all();
        return view('admin.alocacao_material.editar.index', compact('alocacao_material', 'triagems', 'consultas', 'produtos', 'alocacaos', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $alocacaoMaterial = AlocacaoMaterial::findOrFail($id);

            $validated = $request->validate([
                'it_id_triagem' => 'nullable|exists:triagems,id',
                'it_id_consulta' => 'nullable|exists:consultas,id',
                'it_id_produto' => 'required|exists:produtos,id',
                'it_id_alocacao' => 'required|exists:alocacaos,id',
                'it_quantidade' => 'required|integer|min:1',
                'vc_unidade' => 'required|string|max:255',
                'vc_motivo' => 'required|string|max:255',
                'it_id_unidade' => 'required|exists:unidades,id',
            ]);

            $alocacaoMaterial->update($validated);

            $this->registrarNotificacao('atualizou', $alocacaoMaterial);

            return redirect()->route('admin.alocacao_material.index')
                ->with('success', 'Material alocado atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar material alocado: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $alocacaoMaterial = AlocacaoMaterial::findOrFail($id);
            $alocacaoMaterial->delete();

            $this->registrarNotificacao('removeu', $alocacaoMaterial);

            return redirect()->route('admin.alocacao_material.index')
                ->with('success', 'Material alocado eliminado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.alocacao_material.index')
                ->with('error', 'Erro ao eliminar material alocado: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['alocacao_materials'] = AlocacaoMaterial::onlyTrashed()->with(['triagem', 'consulta', 'produto', 'alocacao', 'unidade'])->get();
        return view('admin.alocacao_material.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $alocacaoMaterial = AlocacaoMaterial::onlyTrashed()->findOrFail($id);
            $alocacaoMaterial->restore();

            $this->registrarNotificacao('restaurou', $alocacaoMaterial);

            return redirect()->back()->with('success', 'Material alocado restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar material alocado: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $alocacaoMaterial = AlocacaoMaterial::onlyTrashed()->findOrFail($id);
            $alocacaoMaterial->forceDelete();

            $this->registrarNotificacao('excluiu permanentemente', $alocacaoMaterial);

            return redirect()->back()->with('success', 'Material alocado excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir material alocado permanentemente: ' . $e->getMessage());
        }
    }

    private function registrarNotificacao($acao, $alocacaoMaterial)
    {
        Notificacao::create([
            'it_id_usuario' => Auth::id(),
            'txt_mensagem' => "O usuário " . Auth::user()->vc_pnome . " $acao o Material Alocado ID: " . $alocacaoMaterial->id,
            'vc_titulo' => 'Material Alocado',
            'bl_estado' => false,
            'dt_envio' => now()
        ]);
    }
}
