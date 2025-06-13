<!DOCTYPE html>
<html lang="en" class="astro-FLTEP2YP">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/css/devis.css'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>

    {{-- SEO META --}}
    @stack('meta')
    @if (! View::hasSection('meta'))
        <title>ToqueToque.net – Confiez votre constitution et dépôt de dossiers à des avocats suppléants experts en France</title>
        <meta name="description" content="Plateforme de dépôt judiciaire rapide, sécurisée et gérée par des avocats professionnels dans toute la France.">
        <link rel="canonical" href="{{ url()->current() }}" />
    @endif

    {{-- Styles locaux --}}
    <style>
        .selected {
            border-color: blue;
            background-color: rgba(0, 0, 255, 0.1);
        }
        .checked-icon {
            display: none;
        }
        .selected .checked-icon {
            display: block;
        }
        .btn-selected {
            border-color: blue;
            background-color: rgba(0, 0, 255, 0.1);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>



{{--<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}


<body class="bg-gray-900 dark:bg-gray-900 astro-FLTEP2YP">

<header class="astro-UY3JLCBK">
    <x-nav />
</header>

<x-alert-success />

{{ $slot }}

<x-footer />


</body></html>
