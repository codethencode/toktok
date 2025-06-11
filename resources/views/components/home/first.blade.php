<div class="relative">

   @if (session()->has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show"
         x-transition:leave="transition ease-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"php artisan ser
         class="fixed top-0 left-0 w-full bg-green-500 text-white text-center py-8 p-5 mb-10 shadow-md z-[9999]">
        {{ session('success') }}
    </div>
    @endif


    <div aria-hidden="true" class="absolute inset-0 grid grid-cols-2 -space-x-52 opacity-40 dark:opacity-20">
        {{--            <div class="blur-[106px] h-56 bg-gradient-to-br from-primary to-blue-400 dark:from-blue-700"></div>--}}
        {{--            <div class="blur-[106px] h-32 bg-gradient-to-r from-cyan-400 to-blue-300 dark:to-indigo-600"></div>--}}
    </div>



    <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
        <div class="relative sm:pt-3 md:pt-36 ml-auto">
            <div class="lg:w-3/4 text-center mx-auto">




                 <div class="grid sm:grid-col-1 md:grid-cols-2 gap-1">
                     <div class="flex-1 text-left items-left break-words">
                         {{-- <h1 class="text-left pt-20 text-gray-900 dark:text-white font-bold text-3xl md:text-4xl xl:text-5xl mt-4">Nous déposons vos dossiers juridiques <span class="text-blue-500 dark:text-white">sous 72h auprès des tribunaux français !</span>
                         </h1> --}}
                         <h1 class="text-left pt-20 text-gray-900 dark:text-white font-extrabold text-4xl md:text-4xl xl:text-5xl leading-tight">
    Nous déposons vos dossiers juridiquesss Maestro<br>
    <span class="text-blue-600 dark:text-white">sous <span class="text-6xl text-blue-700 font-black">72h</span> auprès des tribunaux français !</span>
</h1>
                         <div class="pr-3">
                            <a href="/register">
    <button class="mt-10 bg-blue-600 hover:bg-blue-700 w-full rounded-full text-white text-lg font-semibold py-4 px-6 shadow-lg transition-all duration-300">
        Déposer mon dossier à partir de 129€ HT
    </button>
</a>
                            
                            {{-- <a href="/register"><button class="mt-12 bg-blue-500 w-full rounded-full text-white p-4 mt-auto">Déposer mon dossier à partir de 129€ HT</button></a> --}}
                         </div>
                     </div>
                     <!-- ... -->
                     <div class="flex flex-1 justify-center items-center"><img src="{{url('/images/femme-dossier-avocat-min.png')}}" class=""></div>
                 </div>

                 {{--                    {{ $slot }}--}}

                <div class="pt-10">
                    <span class="font-bold text-2xl">Créé par des avocats pour des avocats notre service innovant et unique vous permet de déposer</span><span class="text-blue-600 font-bold text-2xl"> vos dossiers judiciaires dans les juridictions concernés sans vous déplacer !</span>

                </div>





<div class="w-screen relative left-1/2 right-1/2 -translate-x-1/2 bg-gradient-to-r from-indigo-300 to-purple-600 py-20 mt-16 mb-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-12 text-white text-center">
            
            <!-- ÉTAPE 1 -->
            <div class="flex flex-col items-center space-y-4">
                <div class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <strong class="text-xl block mb-2">01 - COMMANDEZ</strong>
                    <span>Paiement par CB<br>100% sécurisé</span>
                </div>
            </div>

            <!-- ÉTAPE 2 -->
            <div class="flex flex-col items-center space-y-4">
                <div class="bg-green-100 w-16 h-16 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 12l1.293 1.293a1 1 0 001.414 0L10 10m0 0l2-2m-2 2l2 2m-2-2l-2-2m-2 6h.01M20 12h.01" />
                    </svg>
                </div>
                <div>
                    <strong class="text-xl block mb-2">02 - TRANSMETTEZ</strong>
                    <span>Nous votre dossier<br>depuis votre interface dédiée</span>
                </div>
            </div>

            <!-- ÉTAPE 3 -->
            <div class="flex flex-col items-center space-y-4">
                <div class="bg-purple-100 w-16 h-16 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m-2 4a9 9 0 110-18 9 9 0 010 18z" />
                    </svg>
                </div>
                <div>
                    <strong class="text-xl block mb-2">03 - Votre dossier est DEPOSÉ</strong>
                    <span>Dans la juridiction choisie<br>sous un délai moyen de 72h</span>
                </div>
            </div>

        </div>
    </div>
</div>




                

{{-- <div class="w-screen relative left-1/2 right-1/2 -translate-x-1/2 bg-purple-400 py-20 mt-10"> --}}
    
    {{-- <div class="w-screen relative left-1/2 right-1/2 -translate-x-1/2 bg-gradient-to-r from-blue-400 to-purple-600 py-20 mt-16 mb-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-6 text-white">
            <div class="flex items-start gap-4">
                <img src="{{ url('/images/icon-card.png') }}" class="w-12 h-12">
                <div>
    <strong class="text-xl block mb-3">01 - COMMANDEZ</strong>
    <span>Paiement par CB<br>100% sécurisé</span>
</div>
            </div>
            <div class="flex items-start gap-4">
                <img src="{{ url('/images/icon-dossier.png') }}" class="w-12 h-12">
                <div>
                    <strong class="text-xl block mb-3">02 - TRANSMETTEZ</strong>
                    <span>nous votre dossier<br>deouis votre interface dédiée</span>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <img src="{{ url('/images/icon-coursier.png') }}" class="w-12 h-12">
                <div>
                    <strong class="text-xl block mb-3">03 - Votre dossier est DEPOSÉ</strong>
                    <span>dans la juridiction choisie<br>sous un délai moyen de 72h</span>
                </div>
            </div>
        </div>
    </div>
</div> --}}



                
                {{-- <div class="grid lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-20 mt-20 bg-purple-400 text-white rounded-3xl p-6 shadow-xl">
    <div class="flex items-start gap-4 hover:scale-105 transition">
        <img src="{{url('/images/icon-card.png')}}" class="w-12 h-12 object-contain">
        <div><strong class="text-purple-100">01 - COMMANDEZ</strong><br><span>la prestation par CB</span></div>
    </div>
    <div class="flex items-start gap-4 hover:scale-105 transition">
        <img src="{{url('/images/icon-dossier.png')}}" class="w-12 h-12 object-contain">
        <div><strong class="text-purple-100">02 - TRANSMETTEZ</strong><br><span>nous votre dossier</span></div>
    </div>
    <div class="flex items-start gap-4 hover:scale-105 transition">
        <img src="{{url('/images/icon-coursier.png')}}" class="w-12 h-12 object-contain">
        <div><strong class="text-purple-100">03 - Votre dossier est DEPOSÉ</strong><br><span>dans la juridiction sous 72h</span></div>
    </div>
</div> --}}
                


                {{-- <div class="grid lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-1 mb-20 pl-10 pr-10 mt-20 bg-black rounded-2xl rounded-br-2xl p-3 text-white">

                    <div class="flex text-left justify-left items-center">
                        <img src="{{url('/images/icon-card.png')}}" class="w-1/4 pl-2 pr-2 items-start">
                        <span class=""><strong class="">01 - COMMANDEZ</strong> la prestation par CB</span>
                    </div>
                    <div class="flex justify-left items-center">
                        <img src="{{url('/images/icon-dossier.png')}}" class="w-1/4 pl-2 pr-2">
                        <span class=""><strong class="">02 - TRANSMETTEZ</strong> nous votre dossier</span>
                    </div>
                    <div class="flex justify-left items-center">
                        <img src="{{url('/images/icon-coursier.png')}}" class="w-1/4 pl-2 pr-2">
                        <span class=""><strong class="">03 - Votre dossier est DEPOSE</strong> dans la juridiction sous 72h</span>
                    </div>
                </div> --}}

                {{-- <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700"> --}}

                <p class="mt-10 text-black dark:text-gray-900">Notre service unique vous permet de nous misisonner pour déposer vos dossiers auprès des juridiction de France Métropolitaines sans vous déplacer. Le paiement est 100% sécurisé et la procédure totalement confidentielle.</p>

                <div class="mt-16 flex flex-wrap justify-center gap-y-4 gap-x-6">
    <a href="/register" class="relative flex h-12 w-full items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:bg-blue-600 before:transition before:duration-300 hover:before:scale-105 active:before:scale-95 sm:w-max shadow-lg">
        <span class="relative text-base font-semibold text-white">Commandez votre dépôt de dossier</span>
    </a>
    {{-- <a href="#" class="relative flex h-12 w-full items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:border before:border-blue-600 before:bg-blue-50 before:transition before:duration-300 hover:before:scale-105 active:before:scale-95 sm:w-max">
        <span class="relative text-base font-semibold text-blue-700">En savoir plus</span>
    </a> --}}
</div>

                {{-- <div class="mt-16 flex flex-wrap justify-center gap-y-4 gap-x-6">
                    <a href="#" class="relative flex h-11 w-full items-center justify-center px-6 before:absolute before:inset-0 before:rounded-full before:bg-blue-500 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max">
                        <span class="relative text-base font-semibold text-white">Commander</span>
                    </a>
                    <a href="#" class="relative flex h-11 w-full items-center justify-center px-6 before:absolute before:inset-0 before:rounded-full before:border before:border-transparent before:bg-blue-100 before:bg-gradient-to-b before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 dark:before:border-gray-700 dark:before:bg-gray-800 sm:w-max">
                        <span class="relative text-base font-semibold text-blue-600 dark:text-white">En savoir plus</span>
                    </a>
                </div> --}}
                {{-- <div class="hidden py-8 mt-16 border-y border-gray-100 dark:border-gray-800 sm:flex justify-between">
                    <div class="text-left">
                        <h6 class="text-lg font-semibold text-gray-700 dark:text-white">Un service unique</h6>
                        <p class="mt-2 text-gray-500">Créé pour les avocats</p>
                    </div>
                    <div class="text-left">
                        <h6 class="text-lg font-semibold text-gray-700 dark:text-white">Gagnez du temps</h6>
                        <p class="mt-2 text-gray-500">Transmettez depuis votre cabinet</p>
                    </div>
                    <div class="text-left">
                        <h6 class="text-lg font-semibold text-gray-700 dark:text-white">Sécurisé & confidentiel</h6>
                        <p class="mt-2 text-gray-500">Nous protégeons et sécurisons vos dossiers</p>
                    </div>
                </div> --}}
<div class="border-t border-b border-gray-100 dark:border-gray-800 py-12 mt-16">
    <div class="max-w-5xl mx-auto flex flex-wrap justify-center gap-24 text-center">
        <div class="w-64">
            <h6 class="text-lg font-semibold text-gray-800 dark:text-white">Un service unique</h6>
            <p class="mt-2 text-gray-500">Créé pour les avocats</p>
        </div>
        <div class="w-64">
            <h6 class="text-lg font-semibold text-gray-800 dark:text-white">Gagnez du temps</h6>
            <p class="mt-2 text-gray-500">Transmettez depuis votre cabinet</p>
        </div>
        <div class="w-64">
            <h6 class="text-lg font-semibold text-gray-800 dark:text-white">Sécurisé & confidentiel</h6>
            <p class="mt-2 text-gray-500">Nous protégeons et sécurisons vos dossiers</p>
        </div>
    </div>
</div>

                



            </div>
            {{-- <div class="mt-12 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6">
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/microsoft.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="">
                </div>
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/airbnb.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="">
                </div>
                <div class="p-4 flex grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/google.svg" class="h-9 w-auto m-auto" loading="lazy" alt="client logo" width="" height="">
                </div>
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/ge.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="">
                </div>
                <div class="p-4 flex grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/netflix.svg" class="h-8 w-auto m-auto" loading="lazy" alt="client logo" width="" height="">
                </div>
                <div class="p-4 grayscale transition duration-200 hover:grayscale-0">
                    <img src="./images/clients/google-cloud.svg" class="h-12 w-auto mx-auto" loading="lazy" alt="client logo" width="" height="">
                </div>
            </div> --}}
        </div>
    </div>
</div>
