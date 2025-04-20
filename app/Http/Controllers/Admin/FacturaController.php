<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Unidade;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $data['unidades'] = Unidade::all();
        $data['facturas'] = Factura::with(['unidade'])->get();
        return view('admin.factura.index', $data);
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('admin.factura.cadastrar.index', compact('unidades'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'unidade_id' => 'required|exists:unidades,id',
                'referencia' => 'nullable|string|max:255',
                'data_emissao' => 'required|date',
                'data_vencimento' => 'required|date|after_or_equal:data_emissao',
                'valor_total' => 'required|numeric|min:0',
                'status' => 'required|string|in:Pendente,Pago,Cancelado',
                'observacao' => 'nullable|string|max:255',
            ]);

            Factura::create($validated);

            return redirect()->route('admin.factura.index')
                ->with('success', 'Fatura registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar fatura: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $factura = Factura::findOrFail($id);
        $unidades = Unidade::all();
        return view('admin.factura.editar.index', compact('factura', 'unidades'));
    }

    public function update(Request $request, $id)
    {
        try {
            $factura = Factura::findOrFail($id);

            $validated = $request->validate([
                'unidade_id' => 'required|exists:unidades,id',
                'referencia' => 'nullable|string|max:255',
                'data_emissao' => 'required|date',
                'data_vencimento' => 'required|date|after_or_equal:data_emissao',
                'valor_total' => 'required|numeric|min:0',
                'status' => 'required|string|in:Pendente,Pago,Cancelado',
                'observacao' => 'nullable|string|max:255',
            ]);

            $factura->update($validated);

            return redirect()->route('admin.factura.index')
                ->with('success', 'Fatura atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar fatura: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $factura = Factura::findOrFail($id);
            $factura->delete();

            return redirect()->route('admin.factura.index')
                ->with('success', 'Fatura excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.factura.index')
                ->with('error', 'Erro ao excluir fatura: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['unidades'] = Unidade::all();
        $data['facturas'] = Factura::onlyTrashed()->with(['unidade'])->get();
        return view('admin.factura.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $factura = Factura::onlyTrashed()->findOrFail($id);
            $factura->restore();

            return redirect()->back()->with('success', 'Fatura restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar fatura: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $factura = Factura::onlyTrashed()->findOrFail($id);
            $factura->forceDelete();

            return redirect()->back()->with('success', 'Fatura excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir fatura permanentemente: ' . $e->getMessage());
        }
    }
}