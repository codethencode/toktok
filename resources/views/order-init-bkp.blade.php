<x-layout>

    <main class="space-y-40 mb-40">

        <div class="relative">

            <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
                <div class="relative sm:pt-3 md:pt-36 ml-auto">
                    <div class="lg:w-3/4 text-center mx-auto">


                        <div class="grid sm:grid-col-1 md:grid-cols-1 gap-1 pt-10 " >
                            <div class="flex-1 text-left items-left break-words mt-10 mb-10">
                                <div class="bg-purple-200 p-5 rounded-lg pl-10 pr-10  min-h-[750px]">
                                    Caractéristiques de votre dossier <br>

                                    <form method="POST" action="order-resume">
                                        @csrf

                                        <div x-data="priceCalculator()">
                                            <div class="mt-4" >
                                                <x-input-label for="city" :value="__('Ville tribunal* (uniquement France métropolitaine et Corse)')" />
                                                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autocomplete="city" />
                                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                            </div>


                                            <div class="mt-4">
                                                <x-input-label for="numberOfPages" :value="__('Nb de pages*')" />
                                                <x-text-input id="numberOfPages" name="numberOfPages" class="block mt-1 w-full" type="text"  :value="old('numberOfPages')" required autocomplete="numberOfPages" x-model.number="numberOfPages" min="1" />
                                                <x-input-error :messages="$errors->get('numberOfPages')" class="mt-2" />
                                            </div>


                                            <div class="mt-4">
                                                <x-input-label for="printType" :value="__('Type Impression*')" />
                                                <select name="printType" id="printType" x-model="printType" class="block mt-1 w-full p-2 rounded-md border-gray-300">
                                                    @php
                                                        $impression="";
                                                          foreach($typeImpressions as $typeImpression)
                                                              {
                                                              $impression .= '<option value="'.$typeImpression['code'].'">'.$typeImpression['libelle'].' ('.$typeImpression['price'].' € / page)</option>';
                                                              }

                                                          echo "$impression";
                                                    @endphp

                                                </select>
                                                <x-input-error :messages="$errors->get('printType')" class="mt-2" />
                                            </div>


                                            <div class="mt-4">
                                                <x-input-label for="reliureQuality" :value="__('Type Impression*')" />
                                                <select name="reliureQuality" id="reliureQuality" x-model="reliureQuality" class="block mt-1 w-full p-2 rounded-md border-gray-300">
                                                    @php
                                                        $reliure="";
                                                          foreach($typeReliures as $typeReliure)
                                                              {
                                                              $reliure .= '<option value="'.$typeReliure['code'].'">'.$typeReliure['libelle'].' ('.$typeReliure['price'].' € / page)</option>';
                                                              }

                                                          echo "$reliure";
                                                    @endphp

                                                </select>
                                                <x-input-error :messages="$errors->get('typeReliure')" class="mt-2" />
                                            </div>



                                            <div class="mt-4">
                                                <x-input-label for="expeType" :value="__('Expédition*')" />
                                                <select name="expeType" x-model="expeType" class="block mt-1 w-full p-2 rounded-md border-gray-300">
                                                    @php
                                                        $expedition="";
                                                          foreach($typeExpeditions as $typeExpedition)
                                                              {
                                                              $expedition .= '<option value="'.$typeExpedition['code'].'">'.$typeExpedition['libelle'].' ('.$typeExpedition['price'].' €)</option>';
                                                              }

                                                          echo "$expedition";
                                                    @endphp

                                                </select>
                                                <x-input-error :messages="$errors->get('expeType')" class="mt-2" />
                                            </div>



                                            <div class="mt-5 bg-purple-100 rounded-lg p-5 mb-5">
                                                <x-input-label class="mb-2" for="member" :value="__('Avec Abonnement mensuel*')" />
                                                <input type="checkbox" id="member" name="member" x-model="applyIncrease" class="form-input p-0 rounded-sm mr-2"
                                                >
                                                <span class="mt-5 text-sm">PLEBISCITE PAR LES AVOCATS : Je m'abonne pour 39 € HT / mois et bénéficie de 30% de remise sur tous les tarifs de mes dossiers (annulable à tout moment après 3 mois d'engagement)</span>

                                            </div>


                                            <input type="hidden" id="totalPriceHidden" name="totalPrice" x-bind:value="totalPrice">


                                            <x-button class="bg-blue-500 mt-6" id="totalGen7" x-text="'Prix Total : ' + totalPrice + ' € HT'"></x-button>

                                        </div>



                                    </form>
                                </div>
                            </div>



                            <div x-data="selectionComponent" class="mx-auto">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <template x-for="option in options" :key="option.id">
                                        <div
                                            @click="selectOption(option)"
                                            :class="{'selected': selectedOption && selectedOption.id === option.id}"
                                            class="p-4 border-2 border-gray-300 rounded cursor-pointer flex justify-between items-center"
                                        >
                                            <div>
                                                <h2 class="text-xl font-bold" x-text="option.title"></h2>
                                                <p class="text-gray-700" x-text="option.description"></p>
                                                <p class="text-lg font-semibold" x-text="`$${option.price}`"></p>
                                            </div>
                                            <div x-show="selectedOption && selectedOption.id === option.id">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="mt-6">
                                    <p x-show="selectedOption" class="text-xl">
                                        Selected Option: <span class="font-bold" x-text="selectedOption.title"></span> - <span class="font-bold" x-text="`$${selectedOption.price}`"></span>
                                    </p>
                                </div>
                            </div>

                            <script>
                                function selectionComponent() {
                                    return {
                                        options: [
                                            { id: 1, title: 'Option 1', description: 'Description for option 1', price: 10 },
                                            { id: 2, title: 'Option 2', description: 'Description for option 2', price: 20 },
                                            { id: 3, title: 'Option 3', description: 'Description for option 3', price: 30 },
                                            { id: 4, title: 'Option 4', description: 'Description for option 4', price: 40 },
                                            { id: 5, title: 'Option 5', description: 'Description for option 5', price: 50 },
                                            { id: 6, title: 'Option 6', description: 'Description for option 6', price: 60 },
                                        ],
                                        selectedOption: null,
                                        init() {
                                            this.selectedOption = this.options[0]; // Sélectionner par défaut la première option
                                        },
                                        selectOption(option) {
                                            this.selectedOption = option;
                                        }
                                    }
                                }
                            </script>






                            <div class="justify-center text-left items-left">
                                <div class="bg-black p-5 rounded-lg text-white">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 p-4">
                                        @foreach($plaidoiries as $plaidoirie)
                                            <div class="bg-blue-500 text-white rounded-lg p-3 min-h-[200px]">
                                                {{ $plaidoirie->description }}
                                                {{ $plaidoirie->price }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>



                            @php
                                $impression="";
                                  foreach($typeImpressions as $typeImpression)
                                      $impression .= $typeImpression['code'].':'.$typeImpression['price'].',';

                                  $reliure="";
                                  foreach($typeReliures as $typeReliure)
                                      $reliure .= $typeReliure['code'].':'.$typeReliure['price'].',';

                                   $expedition="";
                                  foreach($typeExpeditions as $typeExpedition)
                                      $expedition .= $typeExpedition['code'].':'.$typeExpedition['price'].',';
                            @endphp

                            <script>
                                function priceCalculator() {
                                    return {
                                        fees: 15,
                                        numberOfPages: 1,
                                        printType: 'printRSNB',
                                        reliureQuality: 'reliureAVTDC',
                                        expeType: 'expeC',
                                        applyIncrease: false,
                                        basePrices: {
                                            @php
                                                echo $impression;
                                            @endphp
                                            // printRSNB: 0.20,
                                        },
                                        qualityMultipliers: {
                                            @php
                                                echo $reliure;
                                            @endphp
                                            // reliureAVTDC: 15,
                                        },
                                        typeExpeditions: {
                                            @php
                                                echo $expedition;
                                            @endphp
                                            // reliureAVTDC: 15,
                                        },

                                        get totalPrice() {
                                            const basePricePerPage = this.basePrices[this.printType];
                                            const qualityMultiplier = this.qualityMultipliers[this.reliureQuality];
                                            const typeExpedition = this.typeExpeditions[this.expeType];


                                            let totalTxt = "";
                                            let total = (this.numberOfPages * basePricePerPage) + qualityMultiplier + typeExpedition;

                                            if (this.applyIncrease)
                                            {
                                                let ancienPrix = total;
                                                total *= 0.7;
                                                totalTxt = ancienPrix + 'HT Nouveau Prix : ' + total.toFixed(2) + ' HT';
                                            }
                                            else
                                            {
                                                totalTxt = total.toFixed(2);
                                            }
                                            return total.toFixed(2);
                                        }


                                    }
                                }
                            </script>



                            <div class="justify-center text-left items-left">
                                <div class="bg-black p-5 rounded-lg text-white min-h-[750px] md:mt-10">
                                    <span>Bénéficiez de prix remisés en vous abonnant</span>
                                    <div class="text-2xl pt-6 mt-6">-30% sur chaque dépôt de dossier </div>
                                    <div class="text-2xl mt-6 bg-blue-900 p-4 rounded-lg text-right">39 € / mois</div>
                                    <div class="text-md mt-6 rounded-lg text-right mb-10">Annulable à tout moment après 3 mois d'engagement</div>
                                    <a href="#"><x-button class="bg-purple-500 mt-10">Je m'abonne</x-button></a>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layout>
