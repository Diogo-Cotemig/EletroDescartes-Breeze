
    @vite(['resources/css/cadastro.css', 'resources/css/Style.css'])

 <div class="profile-header flex items-center gap-3">
    <h2 class="profile-title">Meu Perfil</h2>

    <img 
        src="{{ asset('img/Eletro-DescarteLOGO.png') }}"
        alt="Logo Eletro Descarte"
        class="profile-logo"
    >
</div>

    <div class="container-profile">

        <section class="card">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="card">
            @include('profile.partials.update-password-form')
        </section>

        <section class="card">
            @include('profile.partials.delete-user-form')
        </section>

    </div>

    <button class="fab" onclick="location.href='{{ route('logado') }}'">🏠</button>