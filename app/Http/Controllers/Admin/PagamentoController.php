<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use App\Models\Factura;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index()
    {
        $data['facturas'] = Factura::all();
        $data['pagamentos'] = Pagamento::with(['factura'])->get();
        return view('admin.pagamento.index', $data);
    }

    public function create()
    {
        $facturas = Factura::all();
        return view('admin.pagamento.cadastrar.index', compact('facturas'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'factura_id' => 'required|exists:facturas,id',
                'data_pagamento' => 'required|date',
                'valor_pago' => 'required|numeric|min:0',
                'metodo_pagamento' => 'required|string|max:255',
            ]);

            Pagamento::create($validated);

            return redirect()->route('admin.pagamento.index')
                ->with('success', 'Pagamento registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar pagamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $pagamento = Pagamento::findOrFail($id);
        $facturas = Factura::all();
        return view('admin.pagamento.editar.index', compact('pagamento', 'facturas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $pagamento = Pagamento::findOrFail($id);

            $validated = $request->validate([
                'factura_id' => 'required|exists:facturas,id',
                'data_pagamento' => 'required|date',
                'valor_pago' => 'required|numeric|min:0',
                'metodo_pagamento' => 'required|string|max:255',
            ]);

            $pagamento->update($validated);

            return redirect()->route('admin.pagamento.index')
                ->with('success', 'Pagamento atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar pagamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $pagamento = Pagamento::findOrFail($id);
            $pagamento->delete();

            return redirect()->route('admin.pagamento.index')
                ->with('success', 'Pagamento excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pagamento.index')
                ->with('error', 'Erro ao excluir pagamento: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['facturas'] = Factura::all();
        $data['pagamentos'] = Pagamento::onlyTrashed()->with(['factura'])->get();
        return view('admin.pagamento.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $pagamento = Pagamento::onlyTrashed()->findOrFail($id);
            $pagamento->restore();

            return redirect()->back()->with('success', 'Pagamento restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar pagamento: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $pagamento = Pagamento::onlyTrashed()->findOrFail($id);
            $pagamento->forceDelete();

            return redirect()->back()->with('success', 'Pagamento excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir pagamento permanentemente: ' . $e->getMessage());
        }
    }
}