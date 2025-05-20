<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilePond Upload</title>
    @vite(['resources/css/app.css','resources/css/devis.css'])
    <!-- Inclure FilePond CSS -->

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <style>
        .filepond--drop-label {
            color: #555;
            font-size: 14px !important ;
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
</head>
<body>

<header class="astro-UY3JLCBK">
    <x-nav />
</header>


<main class="space-y-40 mb-40">

    @auth
        {{--        Logged ! {{ Auth::user()->email; }}--}}
    @endauth

    <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
        <div class="relative sm:pt-3 md:pt-36 ml-auto">
            <div class="lg:w-3/4 text-center mx-auto">


                <div class="flex justify-between mb-5">
                    <a href="account"><button class="bg-blue-500 text-white py-2 px-4 rounded">Mes commandes</button></a>
                    @if($canEdit==='no')
                        <button class="bg-gray-900 text-white py-2 px-4 rounded">Suivant</button>
                    @endif
                </div>


                <h1 class="mb-5">Télécharger les fichiers de mon dossier Etape 1/3 {{ $directory }} // Can Edit : {{ $canEdit }}</h1>
                <!-- Formulaire d'upload -->

                <div class="w-full bg-gray-200 rounded-md h-4 mb-4">
                    <div class="bg-blue-500 h-4 rounded-md" style="width: 30%;"></div>
                </div>


                <div class="bg-purple-200 rounded-lg text-purple-800 p-3 mb-3">Vos fichiers transférés (<span id="countFiles"></span>)</div>

                @if($canEdit==='no')

                    <div class="bg-green-200 text-green-900 rounded-lg p-3 mb-3">
                        Vous avez validé l'envoi de vos fichiers vous ne pouvez plus modifier votre liste de fichiers vous pouvez juste les consulter en cliquant sur le nom de chacun d'entre eux
                    </div>

                @else

                    <form method="POST" action="/send/{{ $directory }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" id="file" required>
                    </form>

                @endif

                <div class="bg-gray-100 rounded-lg p-3" id="buttonSend">

                    <div id="file-list" class="w-500">

                    </div>


                    @if($canEdit==='yes')

                        <div x-data="{ isChecked: false }" class="w-full mt-3">
                            <input type="checkbox" id="accept" class="mr-3" x-model="isChecked">
                            <span class="text-xs w-2/3">Je confirme avoir transmis la totalité de mes fichiers et désire à présent lancer la procédure d'envoi de mon dossier au tribunal.<br>
                        [ ATTENTION ] Je ne pourrai plus apporter aucune modification à mon dossier. Toute modification entrainera des frais supplémentaires.</span>


                            <form method="POST" action="validateUpload">
                                @csrf
                                <input type="hidden" name="directory" value="{{ $directory }}">
                                <button id="card-button"
                                        :disabled="!isChecked"
                                        :class="isChecked ? 'bg-black text-white' : 'bg-gray-400 cursor-not-allowed'"
                                        class="flex flex-1 items-center justify-center mx-auto rounded-lg text-sm w-full bg-black text-white p-3 pl-5 pr-5 align-right mt-6 transition duration-200">
                                    <span class="ml-3">Je valide définitivement l'envoi de mes fichiers</span>
                                </button>

                            </form>

                        </div>

                    @endif



                </div>




                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- Inclure FilePond JS -->
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
                            labelIdle: 'Veuillez glisser/déposer vos fichiers, vous pouvez en sélectionner au <b>maximum 5 à la fois</b>.<br>Vous pouvez répéter l\'opération si nécessaire. Ou <b>cliquez sur parcourir</b><br>Max 20Mo par fichier. <b>Sont acceptés uniquement les fichiers : .pdf, doc, docx, .jpg, .jpeg, .png</b>',
                            labelFileProcessingComplete: 'Téléchargement terminé',
                            labelFileProcessing: 'En cours de transfert',
                            labelTapToUndo: 'Cliquez pour annuler',
                            labelTapToCancel: 'Cliquez pour annuler',
                            allowMultiple: true,
                            allowRevert: true,
                            maxFiles: 5,
                            acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg", "application/pdf", "application/zip", 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                            server: {
                                process: {
                                    url: '/send/{{ $directory }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    onload: (response) => {
                                        const responseData = JSON.parse(response);
                                        // console.log('Uploaded file path:', responseData.path); // Vérifiez ce qui est retourné
                                        return responseData.path; // Ceci est utilisé comme serverId

                                    },
                                    //  onerror: (response) => console.error(response),
                                },
                                revert: {
                                    url: '{{ route('revert') }}',
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    //  onload: (response) => console.log(response), // Pour déboguer la réponse du serveur
                                    // onerror: (response) => console.error(response), //
                                },

                                // revert: null,
                                load: null,
                                fetch: null,
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


                        var directory = '{{ $directory }}'; // Variable Blade
                        var canEdit = '{{ $canEdit }}';     // Variable Blade

                        function refreshFileList() {
                            $.ajax({
                                url: '{{ route('files.index', ['directory' => '__directory__', 'canEdit' => '__canEdit__']) }}'
                                    .replace('__directory__', encodeURIComponent(directory))
                                    .replace('__canEdit__', encodeURIComponent(canEdit)),
                                {{--url: '{{ route('files.index', $orderId) }}',--}}
                                type: 'GET',
                                success: function(response) {
                                    // console.log('Generation de liste :', response); // Debug pour voir la réponse complète
                                    // $('#file-list').html($(response).find('#file-list').html());

                                    $('#file-list').html(response);// Mettez à jour le contenu
                                    var fileCount = $('#file-list div').length;
                                    var statFiles = $('#countFiles').text(fileCount);
                                    if(fileCount<1) { $('#buttonSend').css('display', 'none'); } else { $('#buttonSend').css('display', 'block');}
                                    console.log('Nombre de fichiers : ' + fileCount);
                                },
                                error: function(xhr) {
                                    //console.log('Error:', xhr.responseText); // Debug pour voir les erreurs
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


                </script>

            </div>
        </div>
    </div>
</main>


</body>
</html>
