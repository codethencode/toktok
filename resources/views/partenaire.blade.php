<x-layout>
<section class="py-24 relative">
    <div class="absolute inset-0 pointer-events-none"></div>

    <div class="relative max-w-4xl mx-auto px-6 mt-20">
        {{-- Header 2 colonnes --}}
        <div class="grid md:grid-cols-2 gap-12 items-start mb-16">
         <div class="mb-8">
    <h2 class="text-4xl font-bold text-gray-900 mb-2 dark:text-white ">Devenez partenaire</h2>
    <h3 class="text-lg text-gray-700 dark:text-white ">Devenez avocat suppléant, développez vos revenus</h3>
</div>
            <div>
                <p class="text-gray-700 text-lg leading-relaxed dark:text-white ">
                    Vous êtes avocat ou membre d’un cabinet ? Rejoignez notre réseau national pour élargir votre clientèle. 
                    Ensemble, nous étendons notre service dans toute la France et la Corse. 
                    Une opportunité unique d’intégrer une plateforme moderne et en pleine croissance.
                </p>
            </div>
        </div>

        {{-- Message succès --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('partenaire.submit') }}" class="bg-white p-8 rounded-2xl shadow-xl space-y-6">
            @csrf
            <input type="text" name="honeypot" class="hidden" aria-hidden="true">

            <div class="grid md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm text-gray-700 mb-1">Nom du cabinet *</label>
        <input name="cabinet" type="text" required value="{{ old('cabinet') }}"
               class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label class="block text-sm text-gray-700 mb-1">Site internet (facultatif mais conseillé)</label>
        <input name="site" type="text" value="{{ old('site') }}"
               class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
               placeholder="https://votresite.fr">
    </div>
</div>

            {{-- Ligne 1 --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Nom Prénom *</label>
                    <div class="relative">
                        <input name="nom" type="text" required value="{{ old('nom') }}"
                               class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M5.121 17.804A11.956 11.956 0 0012 20c2.386 0 4.597-.7 6.474-1.9a2.999 2.999 0 00-5.416-2.316L12 17.25l-1.058-1.466a2.999 2.999 0 00-5.416 2.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Téléphone *</label>
                    <div class="relative">
                        <input name="telephone" type="tel" required value="{{ old('telephone') }}"
                               class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                 stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 5h2l3 7v5h4v-5l3-7h2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>


            <div>
    <label class="block text-sm text-gray-700 mb-1">Statut juridique *</label>
    <select name="statut" required
            class="w-full pl-5 h-10 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">-- Sélectionnez --</option>
        <option value="Barreau">Avocat inscrit au Barreau</option>
        <option value="Cour">Avocat à la Cour</option>
        <option value="Autre">Autre (précisez en message)</option>
    </select>
</div>

            {{-- Ligne 2 --}}

            <div class="py-10">Merci de bien vouloir renseigner précisément les infirmations ci dessous. Celles ci nous permettront d'établir notre réseau d'avocats sur tout le territoire et ainsi d'ouvrir toujours plus de zones pour la représentaiton des dossiers de nos clients.</div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Branche de droit *</label>
                    <input name="branche" type="text" required value="{{ old('branche') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Département principal d’exercice *</label>
                    <input name="zone" type="text" required value="{{ old('zone') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Ligne 3 --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Région *</label>
                    <input name="region" type="text" required value="{{ old('region') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Villes desservies (séparées par virgule) *</label>
                    <input name="villes" type="text" required value="{{ old('villes') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Message --}}
            <div>
                <label class="block text-sm text-gray-700 mb-1">Message (facultatif)</label>
                <textarea name="message" rows="4"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('message') }}</textarea>
            </div>

            {{-- Bouton --}}
            <div class="text-center pt-4">
                <button type="submit"
                        class="custom-button bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-full shadow-lg transition">
                    Envoyer ma demande de partenariat
                </button>
            </div>
        </form>
    </div>
</section>
</x-layout>
