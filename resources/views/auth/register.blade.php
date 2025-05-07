<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nome -->
            <div>
                <x-label for="primeiro_nome" value="{{ __('Primeiro Nome') }}" />
                <x-input id="primeiro_nome" class="block mt-1 w-full" type="text" name="primeiro_nome" :value="old('primeiro_nome')" required autofocus autocomplete="given-name" />
            </div>
            <div class="mt-4">
                <x-label for="nomes_meio" value="{{ __('Nomes do Meio (Opcional)') }}" />
                <x-input id="nomes_meio" class="block mt-1 w-full" type="text" name="nomes_meio" :value="old('nomes_meio')" autocomplete="additional-name" />
            </div>
            <div class="mt-4">
                <x-label for="ultimo_nome" value="{{ __('Último Nome') }}" />
                <x-input id="ultimo_nome" class="block mt-1 w-full" type="text" name="ultimo_nome" :value="old('ultimo_nome')" required autocomplete="family-name" />
            </div>

            <!-- Username -->
            <div class="mt-4">
                <x-label for="username" value="{{ __('Nome de Usuário') }}" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            </div>

             <!-- BI -->
            <div class="mt-4">
                <x-label for="bi" value="{{ __('BI (Documento)') }}" />
                <x-input id="bi" class="block mt-1 w-full" type="text" name="bi" :value="old('bi')" required />
            </div>

             <!-- Telefone -->
            <div class="mt-4">
                <x-label for="telefone" value="{{ __('Telefone (Opcional)') }}" />
                <x-input id="telefone" class="block mt-1 w-full" type="tel" name="telefone" :value="old('telefone')" autocomplete="tel" />
            </div>

            <!-- Tipo Usuario -->
            <div class="mt-4">
                 <x-label for="tipo_usuario" value="{{ __('Tipo de Usuário') }}" />
                 <select id="tipo_usuario" name="tipo_usuario" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                     <option value="" disabled {{ old('tipo_usuario') ? '' : 'selected' }}>{{ __('Selecione...') }}</option>
                     <option value="admin" {{ old('tipo_usuario') == 'admin' ? 'selected' : '' }}>Admin</option>
                     <!-- <option value="sindico" {{ old('tipo_usuario') == 'sindico' ? 'selected' : '' }}>Síndico</option> -->
                     <option value="morador" {{ old('tipo_usuario') == 'morador' ? 'selected' : '' }}>Morador</option>
                     <option value="funcionario" {{ old('tipo_usuario') == 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                     <option value="outro" {{ old('tipo_usuario') == 'outro' ? 'selected' : '' }}>Outro</option>
                 </select>
             </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>


            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2">
                                {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Termos de Serviço').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Política de Privacidade').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Já registrado?') }}
                </a>
                <x-button class="ms-4">
                    {{ __('Registrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>