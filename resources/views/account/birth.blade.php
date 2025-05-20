<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File Pond Upload</title>
</head>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<body>
<form action="">
    <input type="file" name="filepond" id="filepond">
</form>
{{-- Jquery Library --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- File Pond Js Cdn --}}
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
{{-- File Pond Jquerys Cdn --}}
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
{{-- File Pond Image Preview Cdn --}}
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);

    $("#filepond").filepond({
        allowImagePreview: true,
        allowImageFilter: true,
        imagePreviewHeight: 100,
        allowMultiple: true,
        allowFileTypeValidation: true,
        allowRevert: true,
        acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg"],
        maxFiles: 5,
        credits: false,
        server: {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            process: {
                url: "/uploadit", // L'URL qui recevra le fichier
                method: "POST",
                withCredentials: false,
                timeout: 7000,
                onload: (response) => {
                    console.log("File upload successful:", response);
                    // Handle response here
                    return response.key; // Optionally return a server-generated key
                },
                onerror: (response) => {
                    // Handle error here
                    return response.data;
                },
                ondata: (formData) => {
                    // You can modify the FormData object before sending it
                    return formData;
                },
            },
            // revert: true,
            restore: "temp/upload/delete",
            fetch: false,
        },
    });

</script>



<form action="{{ route('avatar') }}" method="post">
    @csrf
    <!--  For single file upload  -->
    <input type="file" name="avatar" required/>
    <p class="help-block">{{ $errors->first('avatar') }}</p>

    <!--  For multiple file uploads  -->
    <input type="file" name="gallery[]" multiple required/>
    <p class="help-block">{{ $errors->first('gallery.*') }}</p>

    <button type="submit">Submit</button>
</form>

<script>
    // Set default FilePond options
    FilePond.setOptions({
        server: {
            url: "{{ config('filepond.server.url') }}",
            headers: {
                'X-CSRF-TOKEN': "{{ @csrf_token() }}",
            }
        }
    });

    // Create the FilePond instance
    FilePond.create(document.querySelector('input[name="avatar"]'));
    FilePond.create(document.querySelector('input[name="gallery[]"]'), {chunkUploads: true});
</script>
</body>

</html>
