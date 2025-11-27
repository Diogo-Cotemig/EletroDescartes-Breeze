<!-- Atualizar Senha -->
<section class="bg-white shadow-md rounded-xl p-6 border border-gray-100 mt-8">
    <header class="border-b border-gray-200 pb-4 mb-4">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('Atualizar Senha') }}</h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Use uma senha longa e segura para manter sua conta protegida.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Senha Atual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-500" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nova Senha')" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-500" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Senha')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-lg shadow-sm">
                {{ __('Salvar Alterações') }}
            </x-primary-button>
        </div>
    </form>
</section>
