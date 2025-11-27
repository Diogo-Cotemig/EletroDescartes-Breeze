<!-- Informações do Perfil -->
<section class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
    <header class="border-b border-gray-200 pb-4 mb-4">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Informações do Perfil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __("Atualize suas informações de perfil e endereço de e-mail.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="__('Nome Completo')" class="text-gray-700 font-medium" />
            <x-text-input id="name" name="name" type="text"
                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
        </div>

        <!-- E-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" class="text-gray-700 font-medium" />
            <x-text-input id="email" name="email" type="email"
                class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-sm text-yellow-800">
                        {{ __('Seu e-mail ainda não foi verificado.') }}
                    </p>
                    <button form="send-verification"
                        class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 underline">
                        {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                    </button>
                </div>
            @endif
        </div>

        <!-- Botões -->
        <div class="flex items-center gap-3">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-lg shadow-sm">
                {{ __('Salvar Alterações') }}
            </x-primary-button>

            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg">
                {{ __('Cancelar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600">
                   {{ __('Salvo!') }}
                </p>
            @endif
        </div>
    </form>
</section>
