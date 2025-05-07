<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'primeiro_nome' => ['required', 'string'],
            'nomes_meio' => ['nullable', 'string', 'max:100'],
            'ultimo_nome' => ['required', 'string'],
            'email' => ['required', 'string', 'email', Rule::unique('users', 'email')],
            'username' => ['required', 'string', Rule::unique('users', 'username')],
            'password' => $this->passwordRules(),
            'bi' => ['required', 'string', 'max:14'],
            'telefone' => ['nullable', 'string', 'max:9'],
            'tipo_usuario' => ['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ],
        [
            'password.required' => 'A senha é obrigatória.',
            'condominio_id.exists' => 'O condomínio selecionado é inválido.',
        ])->validate();

        return User::create([
            'primeiro_nome' => $input['primeiro_nome'],
            'nomes_meio' => $input['nomes_meio'] ?? null,
            'ultimo_nome' => $input['ultimo_nome'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'bi' => $input['bi'],
            'telefone' => $input['telefone'] ?? null,
            'tipo_usuario' => $input['tipo_usuario'],
        ]);
    }
}