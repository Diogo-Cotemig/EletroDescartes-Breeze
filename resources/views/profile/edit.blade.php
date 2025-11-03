<x-app-layout>
    @vite(['resources/css/cadastro.css', 'resources/css/Style.css'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Perfil') }}
        </h2>
    </x-slot>

    <div>

             @include('profile.partials.update-profile-information-form')

    </div>

        <div>
             @include('profile.partials.update-password-form')
        </div>


                <div>
             @include('profile.partials.delete-user-form')
                </div>
        </div>
    </div>
    <button class="fab" title="Início" onclick="location.href='{{ route('logado') }}'">🏠</button>
</x-app-layout>
