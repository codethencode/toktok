@if($files)
    @foreach($files as $file)
        <div class="bg-gray-200 text-black p-3 rounded-lg space-y-0 mb-2">
            <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a>
            {{--            <button class="delete-file" data-path="{{ $file }}">Supprimer</button>--}}
            @if($canEdit==='yes')
            <button class="delete-file bg-red-300 p-2 ml-4 text-xs text-red-700 rounded-lg" data-path="{{ Storage::url($file) }}">Supprimer</button>
            @endif
        </div>
    @endforeach
@endif

