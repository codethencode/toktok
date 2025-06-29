<x-layoutAdmin>
    <!-- Titre personnalisé -->
    <x-slot name="title">
        FilePond Upload
    </x-slot>

    <!-- Section pour les fichiers CSS/JS spécifiques à cette page -->
    {{-- <x-slot name="head"> --}}
        @push('head')
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
        <style>
            .filepond--drop-label {
                color: #555;
                font-size: 14px !important;
            }
            .filepond--credits {
                display: none !important;
            }
            .filepond--drop-label {
                padding-top: 10px;
                padding-bottom: 10px;
                padding-left: 20px;
                padding-right: 20px;
                height: 120px;
            }
        </style>
        @endpush
    {{-- </x-slot> --}}

    <!-- Contenu principal -->



                <div class="flex justify-between mb-5 pt-32">
                    <a href="/account">
                        <button class="bg-blue-500 text-white py-2 px-4 rounded">Mes commandes</button>
                    </a>
                    @if($canEdit === 'no')
                        <a href="{{ route('account.enterAddress', ['order_id'=> substr($directory,-11), 'uid'=> Auth::user() ]) }}">
                        <button class="bg-gray-900 text-white py-2 px-4 rounded">Suivant</button>
                        </a>
                    @endif
                </div>

                <h1 class="mb-5 mt-5">Télécharger les fichiers de mon dossier Etape 1/3 {{ substr($directory,-11) }} - <button class="bg-blue-200 pl-3 pr-3 pt-1 pb-1 rounded-md text-sm">Référence Affaire RG : <strong>{{ $order_name }}</strong></button></h1>

                <div class="bg-red-400 p-3 rounded-lg text-white my-5 mt-[30px]">Attention : Il est impératif de nous remettre le bordereau de pièces et la convocation pour l'audience de plaidoirie</div>

                    @isset($isAdmin)
                        @if($isAdmin==='isAdmin')
                            @if($hasFiles)
                      
                        <a href="/download-files/{{$directory}}"><button class="btn btn-primary text-sm rounded-lg p-3
                                            bg-green-500 text-white m-5 pl-10 pr-10 text-sm">
                            📦 Télécharger tous les fichiers (.zip) [ ADMIN ]</button>
                        </a>
                               @endif
                            @endif
                    @endisset


                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-md h-4 mb-4">
                    <div class="bg-blue-500 h-4 rounded-md" style="width: 30%;"></div>
                </div>





 


                <div class="bg-purple-200 rounded-lg text-purple-800 p-3 mb-3">
                    Vos fichiers transférés (<span id="countFiles"></span>)
                </div>

                 @if($canEdit != 'no')
                
                <div class="flex flex-col items-center mt-4 animate-bounce">
    <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v8.586l3.293-3.293a1 1 0 011.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L9 12.586V4a1 1 0 011-1z" clip-rule="evenodd" />
    </svg>
    <span class="text-sm mt-1 text-blue-700 font-semibold">Ajoutez vos fichiers ci-dessous</span>
</div>                

                @endif

                @if($canEdit === 'no')
                    <div class="bg-green-200 text-green-900 rounded-lg p-3 mb-3">
                        Vous avez validé l'envoi de vos fichiers, vous ne pouvez plus modifier votre liste de fichiers. Vous pouvez juste les consulter en cliquant sur le nom de chacun d'entre eux.
                    </div>
                @else
                    <!-- Formulaire d'upload -->
                    <form method="POST" action="/send/{{ $directory }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" id="file" required>
                    </form>
                @endif

                <div class="bg-gray-100 rounded-lg p-3" id="buttonSend">
                    <div id="file-list" class="w-500"></div>

                    @if($canEdit === 'yes')


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
                            <form method="POST" id="validUpload" action="enterAddress">
                                @csrf
                                <input type="hidden" name="directory" value="{{ $directory }}">
                                <input type="hidden" name="hasValid" value="hasValid">
                                <input type="hidden" name="order_name" value="{{ $order_name }}">
                                <button :disabled="!isChecked"
                                        class="w-full px-4 mt-10 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Je valide définitivement l'envoi de mes fichiers

                                </button>
                            </form>


                        </div>

                        @else
                        <a href="{{ route('account.enterAddress', ['order_id'=> substr($directory,-11), 'uid'=> Auth::user() ]) }}">
                        <button class="relative w-full px-4 py-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Vous avez validé l'envoi de vos fichiers, vous pouvez passer à l'étape suivante
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-purple-500 rounded-full animate-pulse"></span>
                        </button>
                        </a>

                    @endif
                </div>


    <!-- Scripts spécifiques à cette page -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        $(document).ready(function() {
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            // Créer un FilePond
            const inputElement = document.querySelector('input[type="file"]');
            const pond = FilePond.create(inputElement);

            // Configuration de l'upload
            FilePond.setOptions({
                labelIdle: 'Veuillez glisser/déposer vos fichiers ou cliquer ici pour parcourir. Max 20Mo par fichier.<br>Sont acceptés : documents pdf, word, jpg, png',
                allowMultiple: true,
                allowRevert: true,
                maxFiles: 5,
                acceptedFileTypes: ["image/png", "image/jpeg", "application/pdf", "application/msword"],
                server: {
                    process: {
                        url: '/send/{{ $directory }}',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        onload: (response) => JSON.parse(response).path,
                    },
                    revert: {
                        url: '{{ route('revert') }}',
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    },
                }
            });

            pond.on('processfile', function(error, file) {
                if (!error) {
                    //  console.log('Fichier traité avec succès:', file);
                    refreshFileList(); // Rafraîchit la liste des fichiers après le traitement réussi
                } else {
                    //   console.error('Erreur lors du traitement du fichier:', error);
                }
            });

            pond.on('removefile', function(error, file) {
                if (!error) {
                    // console.log('Fichier traité avec succès:', file);
                    refreshFileList(); // Rafraîchit la liste des fichiers après le traitement réussi
                } else {
                    // console.error('Erreur lors du traitement du fichier:', error);
                }
            });

            function refreshFileList() {
                $.ajax({
                    url: '{{ route('files.index', ['directory' => $directory, 'canEdit' => $canEdit]) }}',
                    type: 'GET',
                    success: function(response) {
                        $('#file-list').html(response);
                        var fileCount = $('#file-list div').length;
                        $('#countFiles').text(fileCount);
                        $('#buttonSend').toggle(fileCount > 0);
                    },
                    error: function(xhr) {
                        alert('Erreur lors du rafraîchissement de la liste des fichiers');
                    }
                });
            }

            $(document).on('click', '.delete-file', function() {
                var filePath = $(this).data('path');

                var relativePath = filePath.replace('/storage/', '');

                console.log('File path:', filePath); // Debug pour vérifier le chemin du fichier

                $.ajax({
                    url: '{{ route('files.delete') }}',
                    type: 'DELETE',
                    data: {
                        path: filePath,
                        directory: '{{ $directory }}', // Assure-toi que $directory est bien une chaîne et non une variable PHP dans ce contexte
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log('Delete response:', response); // Debug pour voir la réponse de la suppression
                        if (response.status === 'success') {
                            // Mettre à jour la liste des fichiers
                            refreshFileList();





                            // Mettre à jour FilePond
                            const pondFiles = pond.getFiles(); // Assurez-vous que 'pond' est bien défini
                            // console.log('Pond files:', pondFiles);

                            const fileItem = pondFiles.find(file => file.serverId === relativePath);
                            //  console.log('File item to remove:', fileItem);


                            pondFiles.forEach(file => {
                                console.log('File in FilePond:', file.serverId, file);
                            });


                            if (fileItem) {
                                pond.removeFile(fileItem.id);
                                //  console.log('File removed:', fileItem.id);
                            } else {
                                //   console.log('File not found in FilePond:', filePath);
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        //  console.log('Error:', xhr.responseText); // Debug pour voir les erreurs
                        alert('Erreur lors de la suppression du fichier');
                    }
                });
            });


            refreshFileList();
        });



            $(document).ready(function() {
            $('#validUpload').on('submit', function(event) {
                event.preventDefault(); // Empêche la soumission normale du formulaire

                $.ajax({
                    url: '/enterAddress',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Redirection ou mise à jour de l'interface utilisateur après la soumission
                        sessionStorage.setItem('canEdit', JSON.stringify({ canEdit: 'no' }));
                        window.location.href = '/uploadfile/{{$directory}}'; // Remplacez par l'URL de redirection
                    },
                    error: function(xhr) {
                        // Gestion des erreurs
                        console.error('Erreur lors de la soumission du formulaire', xhr);
                    }
                });
            });
        });




    </script>

</x-layoutAdmin>
