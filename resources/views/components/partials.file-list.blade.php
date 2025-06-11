<!-- resources/views/partials/file-list.blade.php -->

@foreach($files as $file)
    <li id="file-{{ md5($file) }}">
        {{ basename($file) }}
        <button class="delete-file" data-path="{{ $file }}">Supprimer</button>
    </li>
@endforeach
