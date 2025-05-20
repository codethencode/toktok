<x-layout>

    <main class="space-y-40 mb-40">


        <div class="relative">
            <div aria-hidden="true" class="absolute inset-0 grid grid-cols-2 -space-x-52 opacity-40 dark:opacity-20">
                {{--            <div class="blur-[106px] h-56 bg-gradient-to-br from-primary to-blue-400 dark:from-blue-700"></div>--}}
                {{--            <div class="blur-[106px] h-32 bg-gradient-to-r from-cyan-400 to-blue-300 dark:to-indigo-600"></div>--}}
            </div>
            <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
                <div class="relative sm:pt-3 md:pt-36 ml-auto">
                    <div class="lg:w-3/4 text-center mx-auto">

                        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                            <div class="flex items-center justify-center">
                                <div class="bg-green-100 p-4 rounded-full">
                                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-800 mt-4">La transmission de votre dossier est validée !</h2>
                            <p class="text-gray-600 mt-2">Notre équipe s'occupe de votre dossier.</p>
                            <a href="/">
                            <button class="mt-6 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                                Retourner à l'accueil
                            </button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        <script>
            localStorage.clear();
        </script>
    </main>

</x-layout>
