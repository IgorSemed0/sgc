<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EspacoReserva;
use App\Models\EspacoComum;
use App\Models\User;
use Illuminate\Http\Request;

class EspacoReservaController extends Controller
{
    public function index()
    {
        $data['espacoComums'] = EspacoComum::all();
        $data['users'] = User::all();
        $data['espacoReservas'] = EspacoReserva::with(['espacoComum', 'user'])->get();
        return view('admin.espaco-reserva.index', $data);
    }

    public function create()
    {
        $espacoComums = EspacoComum::all();
        $users = User::all();
        return view('admin.espaco-reserva.cadastrar.index', compact('espacoComums', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'espaco_id' => 'required|exists:espaco_comums,id',
                'user_id' => 'required|exists:users,id',
                'data_reserva' => 'required|date',
                'hora_inicio' => 'required',
                'hora_fim' => 'required|after:hora_inicio',
                'status' => 'required|string|max:255',
                'observacao' => 'nullable|string|max:255',
            ]);

            EspacoReserva::create($validated);

            return redirect()->route('admin.espaco-reserva.index')
                ->with('success', 'Reserva de espaço registrada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao registrar reserva de espaço: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $espacoReserva = EspacoReserva::findOrFail($id);
        $espacoComums = EspacoComum::all();
        $users = User::all();
        return view('admin.espaco-reserva.editar.index', compact('espacoReserva', 'espacoComums', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $espacoReserva = EspacoReserva::findOrFail($id);

            $validated = $request->validate([
                'espaco_id' => 'required|exists:espaco_comums,id',
                'user_id' => 'required|exists:users,id',
                'data_reserva' => 'required|date',
                'hora_inicio' => 'required',
                'hora_fim' => 'required|after:hora_inicio',
                'status' => 'required|string|max:255',
                'observacao' => 'nullable|string|max:255',
            ]);

            $espacoReserva->update($validated);

            return redirect()->route('admin.espaco-reserva.index')
                ->with('success', 'Reserva de espaço atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar reserva de espaço: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $espacoReserva = EspacoReserva::findOrFail($id);
            $espacoReserva->delete();

            return redirect()->route('admin.espaco-reserva.index')
                ->with('success', 'Reserva de espaço excluída com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.espaco-reserva.index')
                ->with('error', 'Erro ao excluir reserva de espaço: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['espacoComums'] = EspacoComum::all();
        $data['users'] = User::all();
        $data['espacoReservas'] = EspacoReserva::onlyTrashed()->with(['espacoComum', 'user'])->get();
        return view('admin.espaco-reserva.lixeira.index', $data);
    }

    public function restore($id)
    {
        try {
            $espacoReserva = EspacoReserva::onlyTrashed()->findOrFail($id);
            $espacoReserva->restore();

            return redirect()->back()->with('success', 'Reserva de espaço restaurada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar reserva de espaço: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $espacoReserva = EspacoReserva::onlyTrashed()->findOrFail($id);
            $espacoReserva->forceDelete();

            return redirect()->back()->with('success', 'Reserva de espaço excluída permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir reserva de espaço permanentemente: ' . $e->getMessage());
        }
    }
}