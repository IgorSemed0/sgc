<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\Bloco;
use App\Models\Edificio;
use App\Models\Morador;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index()
    {
        $data['blocos'] = Bloco::all();
        $data['edificios'] = Edificio::all();
        $data['unidades'] = Unidade::with(['bloco', 'edificio', 'moradores'])->paginate(10);
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
                'edificio_id' => 'nullable|exists:edificios,id',
                'andar' => 'nullable|integer',
                'status' => 'required|string|max:255',
            ]);
    
            if (!empty($validated['edificio_id'])) {
                $edificio = Edificio::findOrFail($validated['edificio_id']);
                $validated['bloco_id'] = $edificio->bloco_id;
            }
    
            Unidade::create($validated);
    
            return redirect()->route('admin.unidade.index')
                ->with('success', 'Imóvel registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar imóvel: ' . $e->getMessage())
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
                'edificio_id' => 'required|exists:edificios,id',
                'andar' => 'nullable|integer',
                'status' => 'required|string|max:255',
            ]);

            $edificio = Edificio::findOrFail($validated['edificio_id']);
            $validated['bloco_id'] = $edificio->bloco_id;
            
            $unidade->update($validated);
    
            return redirect()->route('admin.unidade.index')
                ->with('success', 'Imóvel atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar imóvel: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            $unidade->delete();

            return redirect()->route('admin.unidade.index')
                ->with('success', 'Imóvel excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.unidade.index')
                ->with('error', 'Erro ao excluir imóvel: ' . $e->getMessage());
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

            return redirect()->back()->with('success', 'Imóvel restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar imóvel: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $unidade = Unidade::onlyTrashed()->findOrFail($id);
            $unidade->forceDelete();

            return redirect()->back()->with('success', 'Imóvel excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir imóvel permanentemente: ' . $e->getMessage());
        }
    }

    /**
     * Store a new Morador from the Unidade index page
     */
    public function moradorStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:moradors,email',
                'telefone' => 'nullable|string|max:20',
                'bi' => [
                    'nullable',
                    'string',
                    'max:20',
                    'unique:moradors,bi',
                    function ($attribute, $value, $fail) use ($request) {
                        if (in_array($request->tipo, ['proprietario', 'inquilino']) && empty($value)) {
                            $fail('O campo BI é obrigatório para proprietários e inquilinos.');
                        } elseif ($request->tipo == 'dependente' && empty($value) && empty($request->cedula)) {
                            $fail('Para dependentes, é necessário fornecer BI ou Cédula.');
                        }
                    },
                ],
                'cedula' => [
                    'nullable',
                    'string',
                    'max:20',
                    'unique:moradors,cedula',
                ],
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|in:Masculino,Feminino,Outro',
                'unidade_id' => 'required|exists:unidades,id',
                'tipo' => 'required|in:proprietario,inquilino,dependente',
                'grau_parentesco' => 'required_if:tipo,dependente',
                'estado_residente' => 'nullable|boolean',
                'dependente_de' => 'required_if:tipo,dependente|exists:moradors,id'
            ]);

            // Verify that the unidade exists
            $unidade = Unidade::findOrFail($validated['unidade_id']);

            if ($request->tipo == 'dependente') {
                $inquilino = Morador::find($request->dependente_de);
                if ($inquilino->unidade_id != $validated['unidade_id']) {
                    throw new \Exception('O responsável deve pertencer à mesma unidade.');
                }
            }
    
            Morador::create($validated);
    
            return redirect()->route('admin.unidade.index')
                ->with('success', 'Morador registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar morador: ' . $e->getMessage())
                ->withInput();
        }
    }
}