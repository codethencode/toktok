<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Upload with FilePond</title>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
</head>
<body class="p-10 bg-gray-100">
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-2">Upload Files</h2>
    <input type="file" class="filepond" name="filepond" multiple>

    <h2 class="text-lg font-semibold mt-6 mb-2">Uploaded Files</h2>
    <ul id="fileList">
        @foreach ($files as $file)
            <li>
                <span>{{ $file }}</span>
                @if ($canEdit)
                    <form action="{{ route('files.delete') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $orderId }}">
                        <input type="hidden" name="file" value="{{ $file }}">
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        FilePond.create(document.querySelector('input.filepond'), {
            server: {
                process: {
                    url: '{{ route('files.upload', $orderId) }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    onload: () => fetchFileList()
                }
            }
        });

        function fetchFileList() {
            axios.get('{{ route('files.list', $orderId) }}')
                .then(response => {
                    const files = response.data.files || [];
                    const fileList = document.getElementById('fileList');
                    fileList.innerHTML = files.length
                        ? files.map(file => `
                                <li>
                                    <span>${file}</span>
                                    <button onclick="deleteFile('${file}')">Delete</button>
                                </li>
                            `).join('')
                        : 'No files available.';
                })
                .catch(error => {
                    console.error('Error fetching file list:', error);
                });
        }

        window.deleteFile = function(file) {
            axios.post('{{ route('files.delete') }}', {
                orderId: '{{ $orderId }}',
                file: file
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    fetchFileList();
                })
                .catch(error => {
                    console.error('Error deleting file:', error);
                });
        };

        fetchFileList();
    });
</script>
</body>
</html>
