<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Condominio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data['condominios'] = Condominio::all();
        $data['users'] = User::with('condominio')->get();
        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data['condominios'] = Condominio::all();
        return view('admin.user.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8',
                'bi' => 'required|string|max:255|unique:users',
                'telefone' => 'nullable|string|max:255',
                'tipo_usuario' => 'required|in:admin,morador,funcionario',
                //'condominio_id' => 'required|exists:condominios,id',
            ]);

            // // Define prefixes for processo based on tipo_usuario
            // $prefix = match ($validated['tipo_usuario']) {
            //     'admin' => 'ADM',
            //     'morador' => 'MOR',
            //     'funcionario' => 'FUN',
            // };

            // // Generate unique processo number
            // $lastProcesso = User::where('processo', 'like', $prefix . '%')
            //     ->orderBy('processo', 'desc')
            //     ->first();
            // $newNumber = $lastProcesso ? (int) substr($lastProcesso->processo, 3) + 1 : 1;
            // $validated['processo'] = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            return redirect()->route('admin.user.index')
                ->with('success', 'Usuário criado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar usuário: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['condominios'] = Condominio::all();
        return view('admin.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'primeiro_nome' => 'required|string|max:255',
                'nomes_meio' => 'nullable|string|max:255',
                'ultimo_nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'password' => 'nullable|string|min:8',
                'bi' => 'required|string|max:255|unique:users,bi,' . $id,
                'telefone' => 'nullable|string|max:255',
                'tipo_usuario' => 'required|in:admin,morador,funcionario',
                //'condominio_id' => 'required|exists:condominios,id',
            ]);

            // // Regenerate processo if tipo_usuario changes
            // if ($user->tipo_usuario !== $validated['tipo_usuario']) {
            //     $prefix = match ($validated['tipo_usuario']) {
            //         'admin' => 'ADM',
            //         'morador' => 'MOR',
            //         'funcionario' => 'FUN',
            //     };
            //     $lastProcesso = User::where('processo', 'like', $prefix . '%')
            //         ->orderBy('processo', 'desc')
            //         ->first();
            //     $newNumber = $lastProcesso ? (int) substr($lastProcesso->processo, 3) + 1 : 1;
            //     $validated['processo'] = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            // }

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('admin.user.index')
                ->with('success', 'Usuário atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.user.index')
                ->with('success', 'Usuário movido para a lixeira com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Erro ao mover usuário para a lixeira: ' . $e->getMessage());
        }
    }

    public function trash()
    {
        $data['condominios'] = Condominio::all();
        $data['users'] = User::onlyTrashed()->with('condominio')->get();
        return view('admin.user.trash', $data);
    }

    public function restore($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();
            return redirect()->back()->with('success', 'Usuário restaurado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao restaurar usuário: ' . $e->getMessage());
        }
    }

    public function purge($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->forceDelete();
            return redirect()->back()->with('success', 'Usuário excluído permanentemente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir usuário permanentemente: ' . $e->getMessage());
        }
    }
}