<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    @vite(['resources/css/app.css', 'resources/css/devis.css'])

    <!-- Section personnalisée pour des styles/scripts additionnels -->
    {{ $head ?? '' }}
</head>
<body>

<header class="astro-UY3JLCBK">
    <x-nav /> <!-- Utilisation d'un autre composant Blade -->
</header>

<main class="space-y-40 mb-40">
    <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
        <div class="relative sm:pt-3 md:pt-36 ml-auto">
            <div class="lg:w-3/4 text-center mx-auto">
    {{ $slot }} <!-- Contenu dynamique -->
            </div>
        </div>
    </div>
</main>

</body>
</html>
