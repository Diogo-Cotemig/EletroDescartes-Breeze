<!-- Excluir Conta -->
<section class="bg-white shadow-md rounded-xl p-6 border border-gray-100 mt-8">
    <header class="border-b border-gray-200 pb-4 mb-4">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('Excluir Conta') }}</h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Ao excluir sua conta, todos os dados serão removidos permanentemente. Faça backup se necessário.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg shadow-sm">
        {{ __('Excluir Conta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">{{ __('Tem certeza que deseja excluir sua conta?') }}</h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Insira sua senha para confirmar a exclusão permanente.') }}
            </p>

            <div class="mt-4">
                <x-text-input id="password" name="password" type="password"
                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                    placeholder="{{ __('Senha') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-500" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-200 hover:bg-gray-300 text-gray-700">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-danger-button class="bg-red-600 hover:bg-red-500 text-white px-5 py-2 rounded-lg shadow-sm">
                    {{ __('Excluir Conta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
