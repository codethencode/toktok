<x-layoutAdmin>
    <!-- Titre personnalisé -->
    <x-slot name="title">
        FilePond Upload
    </x-slot>

    <!-- Section pour les fichiers CSS/JS spécifiques à cette page -->
    <x-slot name="head">

    </x-slot>

    <!-- Contenu principal -->
    {{ $directory }}
    <hr>
    <div class="bg-green-600 text-white p-3 rounded-lg mb-3">
        Réf. Dossier : {{ $order_name }}
    </div>


{{--    <h1>{{ $dossier->exists ? 'Modifier le dossier' : 'Créer un dossier' }}</h1>--}}
<div class="bg-gray-900 text-white p-3 rounded-lg mb-3">Information sur votre Cabinet</div>
    <div class="rounded-lg p-6 mx-auto">
        <form action="{{ route('submit.address') }}" method="POST" class="space-y-6">

            @csrf
            <div class="mt-4">
                <x-input-label for="name" :value="__('Nom Cabinet*')" />
                <x-text-input placeholder="Entrez le nom" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $company->name ?? '')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="adresse" :value="__('Adresse*')" />
                <x-text-input placeholder="Adresse" id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse', $company->adresse ?? '')" required autocomplete="adresse" />
                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="code_postal" :value="__('Code Postal*')" />
                <x-text-input placeholder="Code Postal" id="code_postal" class="block mt-1 w-full" type="text" name="code_postal"
                              :value="old('code_postal', $company->code_postal ?? '')" required autocomplete="Code Postal" />
                <x-input-error :messages="$errors->get('code_postal')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="ville" :value="__('Ville*')" />
                <x-text-input placeholder="Ville" id="ville" class="block mt-1 w-full" type="text" name="ville"
                              :value="old('ville', $company->ville ?? '')" required autocomplete="Ville" />
                <x-input-error :messages="$errors->get('ville')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email*')" />
                <x-text-input placeholder="Email" id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email', $company->email ?? '')" required autocomplete="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="tel" :value="__('Téléphone*')" />
                <x-text-input placeholder="Téléphone" id="tel" class="block mt-1 w-full" type="text" name="tel" :value="old('tel', $company->telephone ?? '')" required autocomplete="Téléphone" />
                <x-input-error :messages="$errors->get('tel')" class="mt-2" />
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="custom-button mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-purple-900">
                    Enregistrer
                </button>


            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif



        </form>


    </div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif


{{--    {{ $directory }}--}}

</x-layoutAdmin>
