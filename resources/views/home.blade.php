<x-layout>

    <main class="space-y-40 mb-40">

        <x-home.first />
        <x-home.4-features />
        <x-home.chars />
        <x-home.testimonials />
        <x-home.get-started />
        <x-home.latest-articles />

        @php
            file_put_contents(storage_path('logs/laravel.log'), '');
        @endphp

        <script>
            localStorage.clear();
        </script>
    </main>

</x-layout>
