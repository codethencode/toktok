<x-layoutAdmin>
    <x-slot name="title">Modifier mes informations</x-slot>

    <div class="max-w-xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">Modifier mes informations</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

         @if((bool) Auth::user()?->registered_with_google)
            <div class="mb-4 p-5 bg-gray-100 text-yellow-800 rounded">
                <strong><span class="mb-2 p-5">🔒 Compte Google :</span></strong><br><br>
                <strong>INFORMATION : Vous vous êtes inscrit avec Google.</strong> Modifier votre email bloquera la connexion via Google<br>Vous devrez vous identifier avec email mot de passe plutôt que de cliquer sur le bouton google
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nom</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border border-gray-300 rounded px-4 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border border-gray-300 rounded px-4 py-2" {{ Auth::user()->registered_with_google ? 'readonly' : '' }}>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="w-full border border-gray-300 rounded px-4 py-2" required pattern="\d{10}" maxlength="10">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nouveau mot de passe</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded px-4 py-2">
                <p class="text-sm text-gray-500">Laissez vide si vous ne souhaitez pas changer votre mot de passe.</p>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            <button type="submit" class="custom-button bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">Mettre à jour</button>
        </form>
    </div>
</x-layoutAdmin>