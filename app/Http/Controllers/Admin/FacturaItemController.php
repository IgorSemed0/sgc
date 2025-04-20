<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacturaItem;
use App\Models\Factura;
use Illuminate\Http\Request;

class FacturaItemController extends Controller
{
    public function index()
    {
        $data['facturas'] = Factura::all();
        $data['facturaItems'] = FacturaItem::with('factura')->get();
        return view('admin.factura-item.index', $data);
    }

    public function create()
    {
        $facturas = Factura::all();
        return view('admin.factura-item.cadastrar.index', compact('facturas'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'factura_id' => 'required|exists:facturas,id',
                'categoria' => 'required|string|max:255',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
            ]);

            FacturaItem::create($validated);

            return redirect()->route('admin.factura-item.index')
                ->with('success', 'Item de Fatura registrado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar item de fatura: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $facturaItem = FacturaItem::findOrFail($id);
        $facturas = Factura::all();
        return view('admin.factura-item.editar.index', compact('facturaItem', 'facturas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $facturaItem = FacturaItem::findOrFail($id);

            $validated = $request->validate([
                'factura_id' => 'required|exists:facturas,id',
                'categoria' => 'required|string|max:255',
                'descricao' => 'required|string|max:255',
                'valor' => 'required|numeric|min:0',
            ]);

            $facturaItem->update($validated);

            return redirect()->route('admin.factura-item.index')
                ->with('success', 'Item de Fatura atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar item de fatura: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $facturaItem = FacturaItem::findOrFail($id);
            $facturaItem->delete();

            return redirect()->route('admin.factura-item.index')
                ->with('success', 'Item de Fatura excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.factura-item.index')
                ->with('error', 'Erro ao excluir item de fatura: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['facturas'] = Factura::all();
        $data['facturaItems'] = FacturaItem::onlyTrashed()->with('factura')->get();
        return view('admin.factura-item.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $facturaItem = FacturaItem::onlyTrashed()->findOrFail($id);
            $facturaItem->restore();

            return redirect()->back()->with('success', 'Item de Fatura restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar item de fatura: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $facturaItem = FacturaItem::onlyTrashed()->findOrFail($id);
            $facturaItem->forceDelete();

            return redirect()->back()->with('success', 'Item de Fatura excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir item de fatura permanentemente: ' . $e->getMessage());
        }
    }
}