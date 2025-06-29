<x-layoutAdmin :title="'FilePond Upload'">

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", function () {
        const el = document.querySelector("#date_audience");
        if (el) {
            flatpickr(el, {
                enableTime: true,
                enableSeconds: true,
                dateFormat: "d/m/Y H:i:S",
                time_24hr: true,
                locale: "fr",
                allowInput: true,
            });
        } else {
            console.error("Input #datetime introuvable !");
        }
    });
</script>
@endpush

    <!-- Titre personnalisé -->
    <x-slot name="title">
        FilePond Upload
    </x-slot>
      
   <x-navtop-account />

    <!-- Section pour les fichiers CSS/JS spécifiques à cette page -->
    <x-slot name="head">

    </x-slot>


    Constitution de votre dossier : Etape 3/4
    <div class="w-full bg-gray-200 rounded-md h-4 mb-4 mt-4">
        <div class="bg-blue-500 h-4 rounded-md" style="width: 70%;"></div>
    </div>
<div class="bg-green-600 text-white p-3 rounded-lg mb-3">
        N° Affaire : {{ strtoupper($order_name) }}
    </div>


    <!-- Contenu principal -->
{{--    {{ $directory }}--}}
{{--    {{ $typeTribunal }}--}}

    @php
        $typeTribunal === 'TribCab' ? $tribTxt = "Cabinet" : $tribTxt = "Tribunal";
    @endphp
{{--    <h1>{{ $dossier->exists ? 'Modifier le dossier' : 'Créer un dossier' }}</h1>--}}
<div class="bg-gray-900 text-white p-3 rounded-lg mb-3">Information sur l'adresse d'expédition de votre dossier vers le {{ $tribTxt }}</div>
    <div class="rounded-lg p-6 mx-auto">
        <form action="{{ route('submit.tribunal') }}" method="POST" class="space-y-6">

            @csrf
            <div class="mt-4">
                <x-input-label for="name" :value="__('Nom '. $tribTxt. '*')" />
                <x-text-input placeholder="Entrez le nom" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $tribunal->name ?? '')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>


            
                @if($tribTxt === "Cabinet")
                
                    <input type='hidden' name='chambre' value='cabinet'>";
                   
                 @else
                  
                    <div class="mt-4">
                    <x-input-label for="chambre" :value="__('Chambre '. $tribTxt .' / Pôle Service Tribunal*')" />
                    <x-text-input placeholder="Entrez la chambre" id="chambre" class="block mt-1 w-full" type="text" name="chambre" :value="old('chambre', $tribunal->chambre ?? '')"  autocomplete="chambre" />
                    <x-input-error :messages="$errors->get('chambre')" class="mt-2" />
                    </div>

                @endif


                    {{-- <div class="mb-6">
            <label for="datetime" class="block text-sm font-medium text-gray-700">Date et heure de l'audience</label>
            <input
                id="datetime"
                name="datetime"
                type="text"
                placeholder="JJ/MM/AAAA HH:MM:SS"
                autocomplete="off"
                class=""
            />
        </div> --}}


            <div class="mt-4">
                <x-input-label for="nom_juge" :value="__('Nom du Juge ou du Juge rapporteur*')" />
                <x-text-input placeholder="Entrez le nom du juge" id="nom_juge" class="block mt-1 w-full" type="text" name="nom_juge" :value="old('nom_juge', $tribunal->nom_juge ?? '')"  autocomplete="nom_juge" />
                <x-input-error :messages="$errors->get('nom_juge')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="adresse" :value="__('Adresse*')" />
                <x-text-input placeholder="Adresse" id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse', $tribunal->adresse ?? '')" required autocomplete="adresse" />
                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="code_postal" :value="__('Code Postal*')" />
                <x-text-input placeholder="Code Postal" id="code_postal" class="block mt-1 w-full" type="text" name="code_postal"
                              :value="old('code_postal', $tribunal->code_postal ?? '')" required autocomplete="Code Postal" />
                <x-input-error :messages="$errors->get('code_postal')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="ville" :value="__('Ville*')" />
                <x-text-input placeholder="Ville" id="ville" class="block mt-1 w-full" type="text" name="ville"
                              :value="old('ville', $tribunal->ville ?? '')" required autocomplete="Ville" />
                <x-input-error :messages="$errors->get('ville')" class="mt-2" />
            </div>


            @php
            $dateValue = old('date_audience', isset($tribunal->date_audience)
                ? \Illuminate\Support\Carbon::parse($tribunal->date_audience)->format('d/m/Y H:i:s')
                : '');
        @endphp


            <div class="mt-4">
                <x-input-label for="date_audience" :value="__('Date et heure de l’audience*')" />
                <x-text-input placeholder="Date et heure de l'audience" id="date_audience" class="block mt-1 w-full" type="text" name="date_audience" :value="$dateValue" autocomplete="off" />
                <x-input-error :messages="$errors->get('date_audience')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="parties_representees" :value="__('Nom/Prénom ou Société de/des Partie(s) représentée(s)*')" />
                <x-text-input placeholder="Parties représentées" id="parties_representees" class="block mt-1 w-full" type="text" name="parties_representees" :value="old('parties_representees', $tribunal->parties_representees ?? '')"  autocomplete="Parties représentées" />
                <x-input-error :messages="$errors->get('parties_representees')" class="mt-2" />
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

        <input type="hidden" name="tribTxt" value="{{ $tribTxt }}">

        </form>


    </div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif


{{--    {{ $directory }}--}}

</x-layoutAdmin>
