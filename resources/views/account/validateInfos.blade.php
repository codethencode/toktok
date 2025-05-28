<x-layoutAdmin>
    <!-- Titre personnalisé -->
    <x-slot name="title">
        FilePond Upload
    </x-slot>

    <!-- Section pour les fichiers CSS/JS spécifiques à cette page -->
    <x-slot name="head">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    </x-slot>

    <!-- Contenu principal -->
{{--    {{ $directory }}--}}


    {{--    <h1>{{ $dossier->exists ? 'Modifier le dossier' : 'Créer un dossier' }}</h1>--}}


   

    <div class="rounded-lg p-6 mx-auto">

        Constitution de votre dossier : Etape 4/4
        <div class="w-full bg-gray-200 rounded-md h-4 mb-4 mt-4">
            <div class="bg-blue-500 h-4 rounded-md" style="width: 90%;"></div>
        </div>

        <div class="bg-gray-900 text-white p-3 rounded-lg mb-8">Récapitulatif des informations transmises</div>


            <div class="grid grid-cols-2 gap-4">
                <!-- Colonne de gauche -->
                <div class="bg-blue-100 p-4 rounded-md text-left">
                    <div class="bg-blue-600 text-white p-3 rounded-lg mb-3">
                        Votre cabinet
                    </div>
                    <div class="ml-3">
                        {{ $company->name }}<br>
                        {{ $company->adresse }}<br>
                        {{ $company->code_postal }} {{ $company->ville }}
                        <br><br>
                        Email : {{ $company->email }}<br>
                        Téléphone : {{ $company->telephone }}
                    </div>
                    </div>

                <!-- Colonne de droite -->
                <div class="bg-green-100 p-4 rounded-md">
                    <div class="bg-green-600 text-white p-3 rounded-lg mb-3 text-left">
                        {{ $tribTxt }} où expédier votre dossier
                    </div>
                    <div class="ml-3 text-left">
                        @if($tribTxt === "Cabinet")
                            {{ $tribunal->name }}<br>
                        @else
                            {{ $tribunal->name }} - Chambre : {{ $tribunal->chambre }}<br>
                        @endif


                        Service : {{ $tribunal->service }}
                        {{ $tribunal->adresse }}<br>
                        {{ $tribunal->code_postal }} {{ $tribunal->ville }}
                        <br><br>
                        Email : {{ $tribunal->email }}<br>
                        Téléphone : {{ $tribunal->telephone }}
                    </div>
                </div>
            </div>

            @if($etat === 'envoiFichier-04' || $etat === 'completed')


       
        
        @if (Auth::check() && Auth::user()->role === 'admin')

        <div class="flex justify-center mt-5 mb-4 bg-blue-100 p-5 rounded-md">

        Voici les fichier pour le dossier&nbsp;<strong>{{ substr($directory, -11) }}</strong>

        </div>

        <div class="flex justify-center mb-4 bg-gray-100 rounded-md p-5">
           
       @php
            
            $dossier = $directory;
            $directory = 'storage/'.$directory;
            
            $directoryPath = public_path($directory);
            $files = [];
    
            if (\Illuminate\Support\Facades\File::exists($directoryPath)) {
                $files = \Illuminate\Support\Facades\File::files($directoryPath);
            }
        @endphp
    
     
    
        @if (count($files) > 0)
            <table class="table-auto w-full border border-gray-300 border-collapse text-sm" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th class="w-[30%] border border-gray-300 px-4 py-2">Nom</th>
                        <th class="w-[30%] border border-gray-300 px-4 py-2">Taille</th>
                        <th class="w-[40%] border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $file->getFilename() }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ number_format($file->getSize() / 1024, 2) }} Ko</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ asset($directory . '/' . $file->getFilename()) }}"
                                   download="{{ $file->getFilename() }}">
                                    📥 Télécharger
                                </a>
                                &nbsp;|&nbsp;
                                <a href="{{ asset($directory . '/' . $file->getFilename()) }}"
                                   target="_blank">
                                    👁️ Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>


        <div class="flex justify-center mb-5 bg-gray-200 rounded-md p-3"> 

            <a href="{{ route('download.all.files', ['folder' => $dossier]) }}" class="btn btn-primary text-sm">
                📦 Télécharger tous les fichiers (.zip)
            </a>
        
        </div>
            @else
            <p>Aucun fichier trouvé dans le dossier.</p>
        @endif
    



        <div class="bg-green-100 w-full rounded-md p-5 mb-5">
            @if($basket->JuriType=='juri_02')
                <div class="bg-red-400 text-white text-sm p-4 mb-4 rounded-md">Remise Mains propres Tribunal</div>
            @endif
            <div class="text-sm"><strong>{{ $basket->juriTypeInfo->label ?? '' }}</strong><br>
            {{ $basket->juriTypeInfo->description ?? '' }}</div>
        </div>




        @if($etat === 'completed')
        <div class="w-full p-2 bg-gray-600 text-white mb-4 p-3 text-sm rounded-md">
            Le dossier a déjà été marqué comme validé et expédié le : <strong>{{ \Carbon\Carbon::parse($step->shipDate)->translatedFormat('d F Y à H\hi') }}</strong>
            <br>si une erreur a été commise dans les informatioons d'envois il est possible de les mettre à jour et de cliquer à nouveau sur valider l'expédition
        </div>
    @endif

        <div class="w-full flex justify-center bg-gray-100 p-6 rounded-md">

        


            <div class="w-full max-w-md">

           
                <div class="text-sm text-gray-700 mb-4 text-center">
                    Renseigner les informations d'expédition ou simplement valider l'expédition (champs non obligatoires)
                </div>

                
        
                <form action="{{ route('orders.confirmShipping', substr($directory, -11)) }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-4">
    @csrf

    {{-- Numéro de suivi --}}
    <div class="flex items-center justify-between">
        <label for="tracking_number" class="text-sm w-1/3 text-gray-600">Numéro de suivi</label>
        <input type="text"
               id="tracking_number"
               name="tracking_number"
               value="{{ old('tracking_number', $step->trackingShip ?? '') }}"
               class="w-2/3 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    {{-- Transporteur --}}
    <div class="flex items-center justify-between">
        <label for="carrier" class="text-sm w-1/3 text-gray-600">Transporteur</label>
        <input type="text"
               id="carrier"
               name="carrier"
               value="{{ old('carrier', $step->carrier ?? '') }}"
               class="w-2/3 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    {{-- Fichier de preuve --}}
    <div class="flex items-center justify-between">
        <label for="proof" class="text-sm w-1/3 text-gray-600">Preuve de dépôt</label>
        <input type="file"
               id="proof"
               name="proof"
               class="w-2/3 border border-gray-300 rounded px-2 py-1 text-sm file:border-0 file:bg-gray-200 file:rounded file:px-2 file:py-1 file:text-sm">
    </div>

    @if(!empty($step->proof_path))
    <div class="flex justify-center mt-2">
        <a href="{{ asset('storage/' . $step->proof_path) }}"
           target="_blank"
           class="text-blue-600 underline text-sm">
            Voir la preuve de dépôt transmise
        </a>
    </div>
    @endif

    {{-- Bouton --}}
    <div class="text-center pt-2">
        <button type="submit"
                class="custom-button bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-all">
            Valider l'expédition
        </button>
    </div>
</form>
            </div>
        </div>


        
        
        <div class="bg-blue-100 p-6 rounded-2xl mt-6 text-sm text-gray-800">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2 border-blue-300">Détails de la commande</h3><a href="/account/orders/{{ substr($directory, -11) }}" target="_blank">(voir le détail complet de la commande)</a>
            
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Ville de dépôt :</span>
                    <span class="font-bold">{{ strtoupper($city) }}</span>
                </div>
        
                <div class="flex justify-between">
                    <span>Nombre de pages :</span>
                    <span class="font-bold">{{ $numberOfPages }}</span>
                </div>
        
                <div class="flex justify-between">
                    <span>Type d’impression :</span>
                    <span class="font-bold">{{ strtoupper($getImpression) }}</span>
                </div>
        
                <div class="flex justify-between">
                    <span>Type de reliure :</span>
                    <span class="font-bold">{{ strtoupper($getReliure) }}</span>
                </div>
        
                <div class="flex justify-between">
                    <span>Expédition :</span>
                    <span class="font-bold">{{ strtoupper($getExpe) }}</span>
                </div>
            </div>
        </div>

    @endif
    

            <div class="bg-green-200 text-green-700 p-6 rounded-lg mt-5">
                Vous avez déjà validé l'envoi de vos informations celles ci ne peuvent plus être modifiées

            </div>

            <a href="/account" class="cursor-pointer">
                <button href="toto" class="bg-gray-900 text-white p-3 cursor-pointer rounded-lg mt-10">Retour à l'accueil</button>
            </a>

            @else



            <div x-data="{ isChecked: false }" class="bg-white p-6">
                <!-- Toggle Switch -->
                <div class="flex justify-center mb-4">
                    <div @click="isChecked = !isChecked"
                         :class="isChecked ? 'bg-green-500' : 'bg-gray-300'"
                         class="relative w-14 h-8 rounded-full cursor-pointer transition-colors duration-300 ease-in-out">
                        <div :class="isChecked ? 'translate-x-6' : 'translate-x-0'"
                             class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 ease-in-out"></div>
                    </div>
                </div>

                <!-- Text explaining the switch -->
                <div class="mb-4 text-gray-600">
                    <span> Je confirme avoir transmis la totalité de mes fichiers et désire à présent lancer la procédure d'envoi de mon dossier au tribunal. [ ATTENTION ] Je ne pourrai plus apporter aucune modification à mon dossier. Toute modification entraînera des frais supplémentaires. </span>
                </div>

                <!-- Submit Button -->
                <form method="POST" id="validUpload" action="/validateInfos">
                    @csrf
                    <input type="hidden" name="directory" value="{{ $directory }}">
                    <input type="hidden" name="hasValid" value="hasValid">
                    <button :disabled="!isChecked"
                            class="w-full px-4 mt-10 py-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Je valide définitivement l'envoi de mes fichiers

                    </button>
                </form>


            </div>
        @endif



            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif






    </div>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif


    {{--    {{ $directory }}--}}

</x-layoutAdmin>
