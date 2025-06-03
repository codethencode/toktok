<div class="relative py-16">
    <!-- Dégradé diffus -->
    <div aria-hidden="true" class="absolute inset-0 h-max w-full m-auto grid grid-cols-2 -space-x-52 opacity-40 dark:opacity-20">
        <div class="blur-[106px] h-56 bg-gradient-to-br from-primary to-purple-400 dark:from-blue-700"></div>
        <div class="blur-[106px] h-32 bg-gradient-to-r from-cyan-400 to-sky-300 dark:to-indigo-600"></div>
    </div>

    <!-- Contenu -->
    <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6 relative">
        <div class="m-auto space-y-10 md:w-9/12 lg:w-8/12 text-center">
            <h2 class="text-4xl font-bold text-gray-800 dark:text-white md:text-5xl">
                Comment fonctionne notre service ?
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Choisissez votre prestation, effectuez le paiement, puis accédez à votre interface sécurisée pour nous transmettre vos pièces. Nous prenons le relais pour la remise au tribunal.
            </p>

            <!-- Étapes en cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mt-12 text-left mb-30">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 transition hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-indigo-600">1</span>
                        <span class="text-sm text-gray-400">Choix</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Choix de la prestation</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Le cabinet sélectionne le type de service souhaité via une interface claire et rapide.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 transition hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-indigo-600">2</span>
                        <span class="text-sm text-gray-400">Paiement</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Paiement en ligne</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Une fois le règlement effectué, un accès sécurisé est activé pour transmettre votre dossier.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6 transition hover:shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-indigo-600">3</span>
                        <span class="text-sm text-gray-400">Remise</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Transmission & dépôt</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Vous nous transmettez vos pièces, nous assurons le dépôt physique au tribunal dans les délais.</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="h-6"></div> <!-- espace vertical supplémentaire de 96px -->
            <div class="flex flex-wrap justify-center gap-6 mt-20">
                <a href="{{ route('order-init') }}" class="relative flex h-12 w-full items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:bg-primary before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max">
                    <span class="relative text-base font-semibold text-white dark:text-dark">Démarrer maintenant</span>
                </a>
                {{-- <a href="{{ route('order-init') }}" class="relative flex h-12 w-full items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:border before:border-transparent before:bg-primary/10 before:bg-gradient-to-b before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 dark:before:border-gray-700 dark:before:bg-gray-800 sm:w-max">
                    <span class="relative text-base font-semibold text-primary dark:text-white">En savoir plus</span>
                </a> --}}
            </div>
        </div>
    </div>
</div>


