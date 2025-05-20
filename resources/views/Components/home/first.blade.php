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
                         <h1 class="text-left pt-20 text-gray-900 dark:text-white font-bold text-3xl md:text-4xl xl:text-5xl mt-4">Nous déposons vos dossiers juridiques <span class="text-blue-500 dark:text-white">sous 72h auprès des tribunaux français !</span>
                         </h1>
                         <div class="pr-3">
                             <a href="/register"><button class="mt-12 bg-blue-500 w-full rounded-full text-white p-4 mt-auto">Déposer mon dossier à partir de 129€ HT</button></a>
                         </div>
                     </div>
                     <!-- ... -->
                     <div class="flex flex-1 justify-center items-center"><img src="{{url('/images/femme-dossier-avocat-min.png')}}" class=""></div>
                 </div>

                 {{--                    {{ $slot }}--}}

                <div class="pt-10">
                    <span class="font-bold text-2xl">Créé par des avocats pour des avocats notre service innovant et unique vous permet de déposer</span><span class="text-blue-600 font-bold text-2xl"> vos dossiers judiciaires dans les juridictions concernés sans vous déplacer !</span>

                </div>


                <div class="grid lg:grid-cols-3 sm:grid-cols-1 md:grid-cols-3 gap-1 mb-20 pl-10 pr-10 mt-20 bg-black rounded-2xl rounded-br-2xl p-3 text-white">

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
                </div>

                <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

                <p class="mt-10 text-black dark:text-gray-900">Notre service unique vous permet de nous misisonner pour déposer vos dossiers auprès des juridiction de France Métropolitaines sans vous déplacer. Le paiement est 100% sécurisé et la procédure totalement confidentielle.</p>
                <div class="mt-16 flex flex-wrap justify-center gap-y-4 gap-x-6">
                    <a href="#" class="relative flex h-11 w-full items-center justify-center px-6 before:absolute before:inset-0 before:rounded-full before:bg-blue-500 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max">
                        <span class="relative text-base font-semibold text-white">Commander</span>
                    </a>
                    <a href="#" class="relative flex h-11 w-full items-center justify-center px-6 before:absolute before:inset-0 before:rounded-full before:border before:border-transparent before:bg-blue-100 before:bg-gradient-to-b before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 dark:before:border-gray-700 dark:before:bg-gray-800 sm:w-max">
                        <span class="relative text-base font-semibold text-blue-600 dark:text-white">En savoir plus</span>
                    </a>
                </div>
                <div class="hidden py-8 mt-16 border-y border-gray-100 dark:border-gray-800 sm:flex justify-between">
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
                </div>
            </div>
            <div class="mt-12 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6">
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
            </div>
        </div>
    </div>
</div>
