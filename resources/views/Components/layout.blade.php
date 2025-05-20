<!DOCTYPE html>
<html lang="en" class="astro-FLTEP2YP">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <meta name="generator" content="Astro v1.1.5">
    <meta name="description" content="Template built with tailwindcss using Tailus blocks v2">
    @vite(['resources/css/app.css','resources/css/devis.css'])
    <title>FaciliPlaide.fr - COnfiez vos dossiers de plaidoieries à une éaquipe d'experts avocats répartis en France</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
{{--    <link rel="stylesheet" href="/assets/index.350e2433.css" />--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>


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

    </style>
</head>

{{--<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}


<body class="bg-white dark:bg-gray-900 astro-FLTEP2YP">

<header class="astro-UY3JLCBK">
    <x-nav />
</header>

{{ $slot }}

<x-footer />


</body></html>
