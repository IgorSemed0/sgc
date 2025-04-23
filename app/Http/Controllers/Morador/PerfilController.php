<?php

namespace App\Http\Controllers\Morador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\UpdateUserPassword;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use Laravel\Fortify\RecoveryCode;
use Google2FA;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('morador.perfil', compact('user'));
    }

    public function updatePassword(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update(auth()->user(), $request->all());
        return back()->with('success', 'Senha atualizada com sucesso.');
    }

    public function twoFactorQrCode()
    {
        $user = auth()->user();
    
        if (!$user->two_factor_confirmed_at) {
            if (!$user->two_factor_secret) {
                $user->two_factor_secret = encrypt(Google2FA::generateSecretKey());
                $user->save();
            }
    
            $svg = (new TwoFactorAuthenticationProvider(app()))->qrCodeSvg(decrypt($user->two_factor_secret));
            return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
        }
    
        return response()->json(['error' => 'Two-factor already enabled'], 403);
    }

    public function confirmTwoFactor(Request $request)
    {
        $user = auth()->user();
        $code = $request->input('code');
        $provider = new TwoFactorAuthenticationProvider(app());
    
        if ($provider->verify(decrypt($user->two_factor_secret), $code)) {
            $user->two_factor_confirmed_at = now();
            $recoveryCodes = RecoveryCode::generate();
            $user->two_factor_recovery_codes = encrypt(json_encode($recoveryCodes));
            $user->save();
            return response()->json(['success' => true, 'recovery_codes' => $recoveryCodes]);
        }
    
        return response()->json(['success' => false, 'message' => 'Código inválido'], 422);
    }

    public function showRecoveryCodes(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);
        $user = auth()->user();
    
        if ($user->two_factor_recovery_codes) {
            $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            return response()->json(['codes' => $codes]);
        }
    
        return response()->json(['message' => 'Não foram encontrados códigos de recuperação'], 404);
    }

    public function disableTwoFactor(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);
        $user = auth()->user();
    
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();
    
        return response()->json(['success' => true]);
    }

    public function logoutOtherSessions(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);
        Auth::logoutOtherDevices($request->password);
        return response()->json(['success' => true]);
    }

    public function deleteAccount(Request $request)
    {
        $request->validate(['password' => ['required', 'current_password']]);
        $user = auth()->user();
        Auth::logout();
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'primeiro_nome' => 'required|string|max:255',
            'nomes_meio' => 'nullable|string|max:255',
            'ultimo_nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'bi' => 'required|string|max:255|unique:users,bi,' . $user->id,
            'telefone' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
