<x-layout>

    <script src="js/calcul_devis.js"></script>

    <main class="space-y-40 mb-40">

        <div class="relative">


            <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
                <div class="relative pt-20 sm:pt-20 md:pt-36 ml-auto">
                    <div class="lg:w-3/4 text-center mx-auto">


                        <div x-data="priceCalculator()" x-init="init()" class="max-w-4xl mx-auto bg-white p-6">


                            <button class="w-full bg-blue-500 text-white p-4 rounded-lg" onclick="submitForm()">Régler votre devis d'un montant de <span x-text="totalPrice"></span> € HT soit <span x-text="$store.myStore.value"></span> € TTC</button>

                            <div class="text-blue-600 mt-6">Calcul de Mon Devis</div>

                            <hr class="border-1 mt-6 mb-0 border-gray-200">

                            <button class="w-full mt-4 mb-3 bg-pink-200 text-sm text-black p-3 rounded-lg" onclick="submitForm()">
                                {{ $baseFeeDesc }} <span class="font-bold">{{ $baseFeePrice }} € HT soit {{ $baseFeePrice*1.2 }} € TTC</span></button>

                            <!-- Ville -->
                            {{--                        <div class="mb-4">--}}
                            {{--                            <label for="ville" class="block text-lg font-medium text-gray-700">Choix de la ville</label>--}}
                            {{--                            <select id="ville" x-model="selectedCity" @change="calculateTotal" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}
                            {{--                                <option value="0" data-id="marseille">Marseille (+0 euros)</option>--}}
                            {{--                                <option value="220" data-id="paris">Paris (+220 euros)</option>--}}
                            {{--                                <option value="300" data-id="melun">Melun (+300 euros)</option>--}}
                            {{--                            </select>--}}
                            {{--                        </div>--}}

                            <div class="grid md:grid-cols-1 sm:grid-cols-1 gap-2 ">






                                <!-- Nombre de pages -->
                                <div class="mt-4">
                                    <x-input-label for="printType" :value="__('Nombre de pages du dossier*')" />
                                    <x-text-input type="number" id="pages" x-model.number="numberOfPages" @input="calculateTotal" min="1" class="mt-1 h-11 bg-blue-100 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                </div>



                            </div>

                            <!-- Type Impression -->
                            <div class="mb-4">
                                <label class="block text-lg font-medium text-gray-700 pb-2 mt-3">Type d'impression</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <template x-for="option in printOptions" :key="option.id">
                                        <div @click="selectPrint(option)" :class="{'selected': selectedPrint && selectedPrint.id === option.id}" class="p-4 border-2 border-gray-300 rounded-lg bg-purple-50 cursor-pointer text-center">
                                            <div class="relative min-h-28">
                                                <h2 class="text-sm font-bold" x-text="option.title"></h2>
                                                <div class="text-gray-700 text-sm bg-pink-100 font-bold p-1 rounded-lg absolute bottom-0 inset-x-0" x-text="option.description"></div>
                                                {{--                                            <p class="text-lg font-semibold" x-text="`$${option.price}`"></p>--}}
                                            </div>
                                            {{--                                        <div x-show="selectedPrint && selectedPrint.id === option.id" class="checked-icon">--}}
                                            {{--                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                                            {{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />--}}
                                            {{--                                            </svg>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Type Reliure -->
                            <div class="mb-4">
                                <label class="block text-lg font-medium text-gray-700 pb-2">Type de reliure</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <template x-for="option in reliureOptions" :key="option.id">
                                        <div @click="selectReliure(option)" :class="{'selected': selectedReliure && selectedReliure.id === option.id}" class="p-4 border-2 bg-blue-50 border-gray-300 rounded-lg cursor-pointer text-center">
                                            <div class="relative min-h-28">
                                                <h2 class="text-sm font-bold" x-text="option.title"></h2>
                                                <div class="text-gray-700 text-sm font-bold bg-blue-100 p-1 rounded-lg absolute bottom-0 inset-x-0" x-text="option.description"></div>
                                                {{--                                            <p class="text-lg font-semibold" x-text="`$${option.price}`"></p>--}}
                                            </div>
                                            {{--                                        <div x-show="selectedReliure && selectedReliure.id === option.id" class="checked-icon">--}}
                                            {{--                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                                            {{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />--}}
                                            {{--                                            </svg>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </template>
                                </div>
                            </div>



                            <!-- Choix de la plaidoirie -->
                            <div class="mb-4">
                                <label class="block text-lg font-medium text-gray-700 pb-2">Choix de la plaidoirie</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <template x-for="option in plaidoirieOptions" :key="option.id">
                                        <div @click="selectPlaidoirie(option)" :class="{'selected': selectedPlaidoirie && selectedPlaidoirie.id === option.id}" class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer flex justify-between items-center">
                                            <div class="relative min-h-48">
                                                <h2 class="text-md font-bold" x-text="option.title"></h2>
                                                <p class="text-gray-700 text-sm" x-text="option.description"></p>
                                                <div class="text-sm font-semibold bg-gray-200 rounded-lg p-1 absolute bottom-0 inset-x-0" x-text="`${option.price} € HT`"></div>
                                            </div>
                                            {{--                                        <div x-show="selectedPlaidoirie && selectedPlaidoirie.id === option.id" class="checked-icon">--}}
                                            {{--                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                                            {{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />--}}
                                            {{--                                            </svg>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </template>
                                </div>
                            </div>


                            <!-- Choix de la plaidoirie -->
                            <div class="mb-4">
                                <label class="block text-lg font-medium text-gray-700 pb-2">Choix de la Juridiction</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <template x-for="option in juridictionOptions" :key="option.id" x-init="resetPrice()">
                                        <div @click="selectJuridiction(option)" :class="{'selected': selectedJuridiction && selectedJuridiction.id === option.id}" class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer flex justify-between items-center">
                                            <div class="relative min-h-48">
                                                <h2 class="text-md font-bold" x-text="option.title"></h2>
                                                <p class="text-gray-700 text-sm" x-text="option.description"></p>
                                                <div class="text-sm font-semibold bg-gray-200 rounded-lg p-1 absolute bottom-0 inset-x-0" x-text="`${option.price} € HT`"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>



                            <div class="mt-6 mb-6" x-show="audience">
                                <span class="text-md">Zone géographique de représentation à l'audience</span>
                                <select name="printType" id="ville" x-model="selectedCity" @change="calculateTotal"  class="block mt-1 w-full h-11 p-1 pl-3 bg-blue-300 rounded-md border-gray-300">
                                    @php
                                        $ville="";

                                          foreach($zone_geos as $zone_geo)
                                              {
                                              if($zone_geo['price']==0)
                                                  {
                                                      $ville .= '<option data-id="'.$zone_geo['code'].'" value="'.$zone_geo['code'].'@'.$zone_geo['price'].'">'.$zone_geo['name'].'</option>';
                                                  }
                                              else
                                                  {
                                                      $ville .= '<option data-id="'.$zone_geo['code'].'" value="'.$zone_geo['code'].'@'.$zone_geo['price'].'">'.$zone_geo['name'].' (+'.$zone_geo['price'].' €)</option>';
                                                  }

                                              }

                                          echo "$ville";
                                    @endphp

                                </select>

                                <x-input-error :messages="$errors->get('printType')" class="mt-2" />
                            </div>


                            <div class="grid sm:grid-cols-2 mt-6 md:grid-cols-2 grid-cols-1 gap-6 pt-3 pb-3 rounded-lg">
                                <!-- Option Urgence -->
                                <div class="mb-4">

                                    <button @click="toggleUrgency" :class="{'btn-selected': isUrgent}" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none bg-gray-100  min-h-[230px] w-full">
                                        <div x-show="!isUrgent"><span class="block text-md font-bold text-white bg-gray-600 rounded-lg p-2 m-3">Option urgence</span><span class="text-sm">(traitement & envoi du dossier sous 24h) 79 euro *
l'envoi et le traitement de votre dosiser sera traité sous 24 heures. La réception de celui-ci au tribunal se fera selon les délai habituels d'expedition de courier en traitement express.</span></div>
                                        <div x-show="isUrgent" class="text-sm"><span class="block text-md font-bold text-gray-700">Option urgence ajoutée</span>Pour un traitement de votre dossier en haute priorité sous 24h prêt à être expédié</div>
                                    </button>
                                </div>


                                <!-- Abonnement mensuel -->
                                <div class="mb-4">

                                    @if($aboState === 'active')

                                        <button class="px-4 py-2 border-2 border-blue-500 bg-purple-200 rounded-lg focus:outline-none min-h-[230px] w-full">
                                            <div x-show="isSubscribed" class="text-sm"><span class="block text-md font-bold text-gray-700">Vous êtes abonné, et disposez de 15% de remise sur la totalité des prestations du site
                                            </div>
                                        </button>

                                    @else

                                        <button @click="toggleSubscription" :class="{'btn-selected': isSubscribed}" class="px-4 py-2 border-2 border-gray-300 bg-purple-500 rounded-lg focus:outline-none min-h-[230px] w-full">
                                            <div x-show="!isSubscribed"><span class="block text-md font-bold text-white bg-purple-600 rounded-lg p-2 m-3">Nouveau ! -15% sur tout en vous abonnant</span>
                                                <span class="text-sm text-white">Ajouter l'abonnement mensuel (+29 euros/mois) vous permet de bénéficier de <strong>15% DE REMISE SUR LA TOTALITE DES PRESTATIONS PROPOSEES</strong> annulable à tout moment après 3 mois d'engagement</div>
                                            <div x-show="isSubscribed" class="text-sm"><span class="block text-md font-bold text-gray-700">Option abonnement mensuel ajoutée</span>Abonnement mensuel 29 euros/mois ajouté vous permettant d'obtenir 15% de remise sur la totalité des prestations du site</div>
                                        </button>

                                    @endif


                                </div>

                            </div>



                            @php
                                $impression="";
                                  foreach($typeImpressions as $typeImpression)
                                      $impression .= "{ id: '". $typeImpression['code']."', title:'".$typeImpression['libelle']."', description: '".$typeImpression['price']." € HT/ page ', price:".$typeImpression['price']." },";

                                  $reliure="";
                                  foreach($typeReliures as $typeReliure)
                                      $reliure .= "{ id: '". $typeReliure['code']."', title:'".$typeReliure['libelle']."', description: '".$typeReliure['price']." € HT / page ', price:".$typeReliure['price']." },";

                                   $plaidoirie="";


                                  foreach($typePlaidoiries as $typePlaidoirie)
                                       $plaidoirie .= "{ id: '". $typePlaidoirie['code']."', title:'".$typePlaidoirie['libelle']."', description:'".addslashes($typePlaidoirie['description'])."', price:".$typePlaidoirie['price']." },";


                                  $juridiction="";

                                  foreach($typeJuridictions as $typeJuridiction)
                                       $juridiction .= "{ id: '". $typeJuridiction['code']."', title:'".$typeJuridiction['libelle']."', description:'".addslashes($typeJuridiction['description'])."', price:".$typeJuridiction['price']." },";


                            @endphp

                            <!-- Prix total -->
                            <div class="mt-6">
                                <form method="POST" id="devisForm" action="payment">
                                    @csrf
                                    <input type="hidden" name="total_price" id="totalTTC" :value="totalTTC">
                                    <input type="hidden" name="selected_city" :value="selectedCity">
                                    <input type="hidden" name="cityCode" id="cityCode" :value="cityCode">
                                    <input type="hidden" name="baseFee" id="baseFee" value="{{ $baseFeePrice }}">
                                    <input type="hidden" name="number_of_pages" :value="numberOfPages">
                                    <input type="hidden" name="print_type" :value="selectedPrint.id">
                                    <input type="hidden" name="print_type_price" :value="selectedPrint.price">
                                    <input type="hidden" name="reliure_type" :value="selectedReliure.id">
                                    <input type="hidden" name="reliure_type_price" :value="selectedReliure.price">
                                    <input type="hidden" name="is_subscribed" :value="isSubscribed ? 'abo' : 'nonabo'">
                                    <input type="hidden" name="selected_plaidoirie" :value="selectedPlaidoirie.id">
                                    <input type="hidden" name="selected_plaidoirie_price" :value="selectedPlaidoirie.price">
                                    <input type="hidden" name="selected_juridiction" :value="selectedJuridiction.id">
                                    <input type="hidden" name="selected_juridiction_price" :value="selectedJuridiction.price">
                                    <input type="hidden" name="is_urgent" :value="isUrgent">
                                    <input type="hidden" name="urgencyPrice"  id="urgencyPrice" value="urgencyPrice">
                                    <input type="hidden" name="has_discount" id="has_discount" value="no">
                                    <input type="hidden" name="codeRemise" id="codeRemise" value="Z">
                                    <input type="hidden" name="aboPrice" id="aboPrice" value="{{ $baseAboPrice }}">
                                    <input type="hidden" name="codeRemisePercent" id="codeRemisePercent" value="0">
                                    <input type="hidden" name="aboState" id="aboState" value="{{ $aboState }}">


                                    <div class="mt-4 mb-8">
                                        <x-input-label for="orderName" :value="__('Attribuez un nom à votre devis* (max 30 caractères)')" />
                                        <x-text-input type="text" name="orderName" id="orderName" max="30" maxlength="30" class="mt-1 h-11 bg-blue-100 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required/>
                                    </div>

                                    <button class="w-full bg-black text-white p-4 rounded-lg">Régler ma commande d'un montant de <span x-text="totalPrice"></span> € HT soit <span x-text="$store.myStore.value"></span> € TTC</button>

                                </form>
                            </div>
                        </div>


                        <div class="container mx-auto mt-2" x-data="discountComponent()" x-show="$store.myRebate.value">
                            <div class="max-w-md mx-auto bg-white p-5 rounded-lg shadow">
                                <h2 class="text-xl font-bold mb-3">Vous disposez d'un code remise ?</h2>
                                <div class="mb-4">
                                    <input type="text" x-model="discountCode" @input="convertToUpperCase" placeholder="Entrez votre code de remise" class="w-full p-2 border border-gray-300 rounded">
                                </div>
                                <div>
                                    <button @click="applyDiscount" :disabled="loading" class="w-full p-2 bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center justify-center">
                                        <span x-show="!loading">Appliquer le Code</span>
                                        <span x-show="loading" class="loader"></span>
                                    </button>
                                </div>
                                <div x-show="message" class="mt-4 p-2 rounded" :class="messageClass">
                                    <span x-text="message"></span>
                                </div>
                                <div x-show="discountApplied" class="mt-4">
                                    <p>Prix initial : <span class="line-through" x-text="formatCurrency(originalPrice)"></span></p>
                                    <p>Nouveau prix : <span class="text-green-500" x-text="formatCurrency(discountedPrice)"></span></p>
                                </div>
                            </div>
                        </div>

{{--                        {{ $aboState }}--}}

                        <script>
                            const sharedData = {};

                            function submitForm()
                            {
                                document.getElementById('devisForm').submit();
                            }

                            function priceCalculator() {

                                return {
                                    selectedCity: localStorage.getItem('selectedCity') || '75@0',
                                    numberOfPages: localStorage.getItem('numberOfPages') || 1,
                                    selectedPrint: null,
                                    selectedReliure: null,
                                    isSubscribed: false,
                                    selectedPlaidoirie: null,
                                    selectedJuridiction: null,
                                    isUrgent: false,
                                    totalPrice: 0.00,
                                    audience: localStorage.getItem('audience') || true,

                                    printOptions: [
                                        //{ id: 'print1', title: 'Noir et blanc recto', description: '0.10 euros / pages', price: 0.10 },
                                        //{ id: 'print2', title: 'Noir et blanc recto/verso', description: '0.15 euros / pages', price: 0.15 },
                                        @php
                                            echo $impression
                                        @endphp
                                    ],

                                    reliureOptions: [
                                        //{ id: 'reliure1', title: 'Reliure transparente 1', description: '+ 10 euros', price: 10 },
                                        //{ id: 'reliure2', title: 'Reliure transparente 2', description: '+ 20 euros', price: 20 },
                                        @php
                                            echo $reliure
                                        @endphp
                                    ],
                                    plaidoirieOptions: [
                                        //{ id: 'plaidoirie1', title: 'Plaidoirie 1', description: 'Description 1', price: 50 },
                                        //{ id: 'plaidoirie2', title: 'Plaidoirie 2', description: 'Description 2', price: 75 },
                                        // Ajoutez d'autres options ici
                                        @php
                                            echo $plaidoirie
                                        @endphp
                                    ],
                                    juridictionOptions: [
                                        //{ id: 'plaidoirie1', title: 'Plaidoirie 1', description: 'Description 1', price: 50 },
                                        //{ id: 'plaidoirie2', title: 'Plaidoirie 2', description: 'Description 2', price: 75 },
                                        // Ajoutez d'autres options ici
                                        @php
                                            echo $juridiction
                                        @endphp
                                    ],
                                    init() {

                                        if (localStorage.getItem('printType')) {
                                            this.selectedPrint = JSON.parse(localStorage.getItem('printType'));
                                        }
                                        else
                                        {
                                            this.selectedPrint = this.printOptions[0];
                                        }

                                        if (localStorage.getItem('reliureType')) {
                                            this.selectedReliure = JSON.parse(localStorage.getItem('reliureType'));
                                        }
                                        else
                                        {
                                            this.selectedReliure = this.reliureOptions[0];
                                        }

                                        if (localStorage.getItem('plaideType')) {
                                            this.selectedPlaidoirie = JSON.parse(localStorage.getItem('plaideType'));
                                        }
                                        else
                                        {
                                            this.selectedPlaidoirie = this.plaidoirieOptions[0];
                                        }

                                        if (localStorage.getItem('juriType')) {
                                            this.selectedJuridiction = JSON.parse(localStorage.getItem('juriType'));
                                        }
                                        else
                                        {
                                            this.selectedJuridiction = this.juridictionOptions[0];
                                        }

                                        if (localStorage.getItem('audience')) {
                                            this.audience = JSON.parse(localStorage.getItem('audience'));
                                        }
                                        else
                                        {
                                            this.audience = true;
                                        }

                                        if (localStorage.getItem('abo')) {
                                            this.isSubscribed = JSON.parse(localStorage.getItem('abo'));
                                        }

                                        if (localStorage.getItem('urgent')) {
                                            this.isUrgent = JSON.parse(localStorage.getItem('urgent'));
                                        }

                                        //this.selectedReliure = this.reliureOptions[0];
                                        //this.selectedPlaidoirie = this.plaidoirieOptions[0];

                                        this.resetPrices();
                                        this.calculateJuridiction();
                                        this.calculateTotal();
                                        //this.audience = true;

                                        Alpine.store('myRebate', {
                                            value: true
                                        });

                                        if (localStorage.getItem('abo')) {
                                            if(JSON.parse(localStorage.getItem('abo'))===true) {
                                                Alpine.store('myRebate').value = false;
                                                }
                                        }
                                        if("{{ $aboState }}" === 'active'){
                                                Alpine.store('myRebate').value = false;
                                                this.isSubscribed = true;
                                        }

                                    },

                                    selectPrint(option) {
                                        this.selectedPrint = option;
                                        this.calculateTotal();
                                    },

                                    selectReliure(option) {
                                        this.selectedReliure = option;
                                        this.calculateTotal();
                                    },


                                    selectJuridiction(option) {
                                        this.selectedJuridiction = option;

                                        //alert(option.id);
                                        if((option.id==="TribJud")||(option.id==="TribCab"))
                                        {

                                            this.audience = false;
                                            localStorage.setItem('juridiction', JSON.stringify(false));
                                        }
                                        else
                                        {
                                            this.audience = true;
                                            localStorage.setItem('juridiction', JSON.stringify(true));
                                        }


                                        this.calculateTotal();
                                    },

                                    selectPlaidoirie(option) {
                                        this.selectedPlaidoirie = option;
                                        //alert(option.id);
                                        this.resetPrices();

                                        if((option.id==="DontKnow")||(option.id==="RepDevis"))
                                        {
                                          //alert(this.selectedJuridiction.id);
                                            if((this.selectedJuridiction.id != "TribJud")&&(this.selectedJuridiction.id != "TribCab"))
                                            {
                                                this.selectedJuridiction.price = 199;
                                            }
                                            this.audience = false;
                                            //this.resetPrices();
                                            localStorage.setItem('audience', JSON.stringify(false));
                                        }
                                        else
                                        {
                                            this.audience = true;
                                            localStorage.setItem('audience', JSON.stringify(true));
                                        }
                                        this.calculateTotal();
                                    },

                                    toggleSubscription() {
                                        this.isSubscribed = !this.isSubscribed;
                                        Alpine.store('myRebate').value = !Alpine.store('myRebate').value;
                                        localStorage.setItem('abo', JSON.stringify(this.isSubscribed));
                                        this.calculateTotal();
                                    },

                                    toggleUrgency() {
                                        this.isUrgent = !this.isUrgent;
                                        localStorage.setItem('urgent', JSON.stringify(this.isUrgent));
                                        this.calculateTotal();
                                    },



                                    resetPrices() {
                                        this.juridictionOptions.forEach(option => {
                                            option.price = 0; // Définit chaque prix à zéro
                                        })
                                    },


                                    calculateJuridiction()
                                    {
                                        this.selectedPrice = this.selectedJuridiction.price;

                                        if((this.selectedPlaidoirie.price>0) && (this.selectedJuridiction.id==="TribJcp")){
                                            this.selectedJuridiction.price = 0;
                                        }

                                        else if((this.selectedPlaidoirie.id === 'RepDevis') || (this.selectedPlaidoirie.id === 'DontKnow')){
                                            this.selectedJuridiction.price = 199;
                                        }
                                        else{
                                            this.selectedJuridiction.price = 0;
                                        }

                                        if((this.selectedJuridiction.id==="TribJud") || (this.selectedJuridiction.id==="TribCab")){
                                            this.selectedJuridiction.price = 0;
                                        }

                                        if(this.selectedPlaidoirie.price>0)
                                        {
                                            this.selectedJuridiction.price = 0;
                                        }
                                        //this.selectedJuridiction.price = 1500;
                                        //alert(this.selectedJuridiction.price);
                                    },


                                    calculateTotal() {

                                        this.calculateJuridiction();

                                        const chaineCity = this.selectedCity;
                                        const valeurs = chaineCity.split('@');
                                        const cityCode = valeurs[0];
                                        let cityPrice = parseFloat(valeurs[1]);


                                        localStorage.setItem('selectedCity', this.selectedCity);
                                        localStorage.setItem('numberOfPages', this.numberOfPages);
                                        localStorage.setItem('audience', this.audience);
                                        localStorage.setItem('printType', JSON.stringify(this.selectedPrint));
                                        localStorage.setItem('reliureType', JSON.stringify(this.selectedReliure));
                                        localStorage.setItem('plaideType', JSON.stringify(this.selectedPlaidoirie));
                                        localStorage.setItem('plaideJuri', JSON.stringify(this.selectedJuridiction));

                                        if(this.audience===false) { this.cityCode = 0; }

                                        document.getElementById('cityCode').value=cityCode;
                                        const baseFee = parseFloat(document.getElementById('baseFee').value);

                                        //const cityPrice = parseFloat(this.selectedCity);
                                        const pagePrice = parseFloat(this.selectedPrint.price) * parseFloat(this.numberOfPages);
                                        const reliurePrice = parseFloat(this.selectedReliure.price);
                                        const abonnementPrice = this.isSubscribed ? {{ $baseAboPrice }} : 0;
                                        const plaidoiriePrice = parseFloat(this.selectedPlaidoirie.price);
                                        const juridictionPrice = parseFloat(this.selectedJuridiction.price);
                                        const urgencyPrice = this.isUrgent ? {{ $baseUrgentPrice }} : 0;


                                        document.getElementById('urgencyPrice').value=urgencyPrice;

                                        if(this.audience === false) { cityPrice = 0; }

                                        const total = baseFee + cityPrice + pagePrice + reliurePrice + abonnementPrice + plaidoiriePrice + juridictionPrice + urgencyPrice;

                                        if (abonnementPrice === 29) {

                                            this.totalPrice = (total*0.85).toFixed(2);

                                        }
                                        else
                                        {
                                            this.totalPrice = total.toFixed(2);
                                        }

                                        if("{{ $aboState }}" === 'active')
                                        {

                                           this.totalPrice = ((total - abonnementPrice)*0.85).toFixed(2);
                                           //alert(total - abonnementPrice + '\n' + this.totalPrice +'HT');
                                        }

                                        this.totalTTC = (this.totalPrice*1.2).toFixed(2);
                                        sharedData.value = this.totalTTC;


                                        Alpine.store('myStore', {
                                            value: this.totalTTC
                                        });

                                        // this.$store.myStore.value = this.totalTTC;

                                    }
                                }


                            }

                            function discountComponent() {

                                return {

                                    discountCode: '',
                                    originalPrice: document.getElementById('totalTTC').value, // Prix initial (à adapter selon vos besoins)
                                    discountedPrice: 0,
                                    loading: false,
                                    message: '',
                                    messageClass: '',
                                    discountApplied: false,
                                    convertToUpperCase() {
                                        this.discountCode = this.discountCode.toUpperCase();
                                    },
                                    formatCurrency(value) {
                                        return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
                                    },
                                    async applyDiscount() {

                                        this.originalPrice = sharedData.value;
                                        this.loading = true;
                                        this.message = '';
                                        this.discountApplied = false;

                                        // Définir un délai minimum de 2 secondes
                                        const minDelay = new Promise(resolve => setTimeout(resolve, 2000));

                                        try {
                                            const response = await fetch('/apply-discount', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ code: this.discountCode })
                                            });

                                            const data = await response.json();

                                            // Attendre que les deux promesses se résolvent
                                            await Promise.all([minDelay, Promise.resolve(data)]);

                                            this.loading = false;

                                            if (data.success) {

                                                const discountPercentage = data.discount;
                                                this.totalPrice = document.getElementById('totalTTC').value;
                                                this.discountedPrice = document.getElementById('totalTTC').value - (document.getElementById('totalTTC').value * discountPercentage / 100);
                                                this.$store.myStore.value = document.getElementById('totalTTC').value + ' € TTC VOTRE NOUVEAU PRIX : ' + this.discountedPrice.toFixed(2);

                                                document.getElementById('totalTTC').value = this.discountedPrice.toFixed(2);
                                                document.getElementById('codeRemise').value = this.discountCode;
                                                document.getElementById('codeRemisePercent').value = discountPercentage;
                                                document.getElementById('has_discount').value = "yes";


                                                this.message = `Remise de ${discountPercentage}% appliquée sur votre tarif.`;
                                                this.messageClass = 'bg-green-100 text-green-700';
                                                this.discountApplied = true;
                                            } else {
                                                this.message = 'Code faux.';
                                                this.messageClass = 'bg-red-100 text-red-700';
                                                document.getElementById('has_discount').value = "no";
                                            }
                                        } catch (error) {
                                            await minDelay; // Assurez-vous d'attendre au moins 2 secondes même en cas d'erreur
                                            this.loading = false;
                                            this.message = 'Une erreur est survenue. Veuillez réessayer.';
                                            this.messageClass = 'bg-red-100 text-red-700';
                                        }
                                    }
                                }
                            }

                        </script>


                    </div>


                </div>
            </div>
        </div>

    </main>

</x-layout>
