<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/css/devis.css'])
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <title>File Pond Upload</title>
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






<form action="">
    @csrf
    <input type="file" name="filepond" id="filepond">
</form>


                <div class="bg-gray-100 p-3 rounded-lg">
                    <div class="bg-gray-900 p-3 text-white rounded-lg mb-5">Votre liste de fichiers envoyés</div>
                    <div id="file-list">
                        @include('partials.file-list', ['files' => $files])
                    </div>
                </div>


                <div x-data="{ isChecked: false }" class="w-full mt-3">
                    <input type="checkbox" id="accept" class="mr-3" x-model="isChecked">
                    <span class="text-xs w-2/3">Je confirme avoir transmis la totalité de mes fichiers et désire à présent lancer la procédure d'envoi de mon dossier au tribunal. Je ne pourrai plus apporter aucune modification à mon dossier. Toute modification entraienera des frais supplémentaires.</span>

                    <button id="card-button"
                            :disabled="!isChecked"
                            :class="isChecked ? 'bg-black text-white' : 'bg-gray-400 cursor-not-allowed'"
                            class="flex flex-1 items-center justify-center mx-auto rounded-lg text-sm w-full bg-black text-white p-3 pl-5 pr-5 align-right mt-6 transition duration-200">
                        <span class="ml-3">Je valide définitivement l'envoi de mes fichiers</span>
                    </button>
                </div>


            </div>
        </div>
    </div>
</main>
{{-- Jquery Library --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- File Pond Js Cdn --}}
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
{{-- File Pond Jquerys Cdn --}}
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
{{-- File Pond Chunck --}}
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
{{-- File Pond Image Preview Cdn --}}
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

<script>

    $(document).ready(function() {

    FilePond.registerPlugin(FilePondPluginFileEncode, FilePondPluginImagePreview);

    // Ajout de la traduction
    FilePond.setOptions({
        labelIdle: 'Glissez & déposez vos fichiers ou <span class="filepond--label-action"> Parcourir </span>',
        labelInvalidField: 'Le champ contient des fichiers invalides',
        imageValidateSizeLabelImageResolutionTooLow: 'La résolution est trop faible',
        imageValidateSizeLabelImageResolutionTooHigh: 'La résolution est trop élevée',
        chunkUploads: true, // Activer le découpage des fichiers
        chunkSize: 10000000, // Taille de chaque morceau (ici 10MB)
        resume: true // Permet la reprise des uploads interrompus
    });

    {{--const pond = $("#filepond").filepond({--}}
    {{--    allowImagePreview: false,--}}
    {{--    allowImageFilter: true,--}}
    {{--    imagePreviewHeight: 100,--}}
    {{--    allowMultiple: true,--}}
    {{--    allowFileTypeValidation: true,--}}
    {{--    allowRevert: true,--}}
    {{--    acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg"],--}}
    {{--    maxFiles: 5,--}}
    {{--    credits: false,--}}
    {{--    server: {--}}
    {{--        headers: {--}}
    {{--            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
    {{--        },--}}
    {{--        process: {--}}
    {{--            url: "/uploadit/{{ $orderId }}",--}}
    {{--            method: "POST",--}}
    {{--            withCredentials: false,--}}
    {{--            timeout: 7000,--}}
    {{--        },--}}
    {{--        revert: '{{ route('revert') }}',--}}

    {{--    },--}}
    {{--});--}}

    {{--pond.on('FilePond:processfile', function(e) {--}}
    {{--    console.log('file added event', e.detail);--}}
    {{--});--}}


    // Initialisation de FilePond sur l'élément DOM directement
    const pondElement = document.querySelector('#filepond');
    const pond = FilePond.create(pondElement, {
        allowImagePreview: false,
        allowImageFilter: true,
        maxFileSize: '100MB',
        imagePreviewHeight: 100,
        allowMultiple: true,
        allowFileTypeValidation: true,
        allowRevert: true,
        acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg", "application/pdf", "application/zip"],
        maxFiles: 5,
        credits: false,
        chunkUploads: true, // Activer le chunking
        chunkSize: 1048576, // Taille de chaque chunk en octets (ici, 1 Mo)
        chunkRetryDelays: [500, 1000, 3000],
        server: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            process: {
                url: "/uploadit/{{ $orderId }}",
                method: "POST",
                withCredentials: false,
                timeout: 700000,
            },
            revert: '{{ route('revert') }}',
        },
    });

    pond.on('processfile', function(error, file) {
        if (!error) {
            console.log('Fichier traité avec succès:', file);
            refreshFileList(); // Rafraîchit la liste des fichiers après le traitement réussi
        } else {
            console.error('Erreur lors du traitement du fichier:', error);
        }
    });

    pond.on('removefile', function(error, file) {
        if (!error) {
            console.log('Fichier traité avec succès:', file);
            refreshFileList(); // Rafraîchit la liste des fichiers après le traitement réussi
        } else {
            console.error('Erreur lors du traitement du fichier:', error);
        }
    });


    function refreshFileList() {
        $.ajax({
            url: '{{ route('files.index', $orderId) }}',
            type: 'GET',
            success: function(response) {
                console.log('Response received:', response); // Debug pour voir la réponse complète
                // $('#file-list').html($(response).find('#file-list').html());
                $('#file-list').html(response);// Mettez à jour le contenu
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText); // Debug pour voir les erreurs
                alert('Erreur lors du rafraîchissement de la liste des fichiers');
            }
        });
    }





        var directory = "{{ $orderId }}";

        {{--function refreshFileList() {--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('files.index', $orderId) }}',--}}
        {{--        type: 'GET',--}}
        {{--        success: function(response) {--}}
        {{--            console.log('Response received:', response); // Debug pour voir la réponse complète--}}
        {{--           // $('#file-list').html($(response).find('#file-list').html());--}}
        {{--            $('#file-list').html(response);// Mettez à jour le contenu--}}
        {{--        },--}}
        {{--        error: function(xhr) {--}}
        {{--            console.log('Error:', xhr.responseText); // Debug pour voir les erreurs--}}
        {{--            alert('Erreur lors du rafraîchissement de la liste des fichiers');--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        $(document).on('click', '.delete-file', function() {
            var filePath = $(this).data('path');

            $.ajax({
                url: '{{ route('files.deleteajax') }}',
                type: 'DELETE',
                data: {
                    path: filePath,
                    directory: directory,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Delete response:', response); // Debug pour voir la réponse de la suppression
                    if (response.status === 'success') {
                        refreshFileList(); // Rafraîchit la liste des fichiers
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText); // Debug pour voir les erreurs
                    alert('Erreur lors de la suppression du fichier');
                }
            });
        });

        // Initialement charger la liste des fichiers
        refreshFileList();
    });
</script>





</body>

</html>
