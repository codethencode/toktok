<x-layout>

    <main class="space-y-40 mb-40">

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative sm:pt-3 md:pt-36 ml-auto">
                <div class="lg:w-3/4 text-center mx-auto">

                    <div class="grid sm:grid-col-1 md:grid-cols-1 bg-purple-200 gap-1 p-10 rounded-lg">
                        <div class="flex-1 text-left items-left break-words pl-10 md:pr-16 pt-5">

                                <form action="{{ route('subscribe') }}" method="POST" id="payment-form">
                                    @csrf
{{--                                    <div>--}}
{{--                                        <label for="card-holder-name">Card Holder Name</label>--}}
{{--                                        <input id="card-holder-name" class="form-input" type="text">--}}
{{--                                    </div>--}}


                                    <input type="hidden" name="toPay" value="{{ $toPay }}">
                                    <input type="hidden" name="is_subscribed" value="{{ $is_subscribed }}">
                                    <input type="hidden" name="aboPrice" value="{{ $aboPrice }}">
                                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                                    <input type="hidden" name="aboState" value="{{ $aboState}}">
                                    <input type="hidden" name="mail" value="{{ $mail}}">

                                    <div class="mt-4">
                                        <x-input-label for="card-holder-name" :value="__('Nom*')" />
                                        <x-text-input id="card-holder-name" class="block mt-1 w-full" type="text" name="card-holder-name" :value="old('name')" required autocomplete="name" />
                                        <x-input-error :messages="$errors->get('card-holder-name')" class="mt-2" />
                                    </div>

                                    <!-- Stripe Elements Placeholder -->
                                    <div id="card-element" class="p-3 bg-white rounded-lg mt-3"></div>

                                    <div class="text-center items-center" x-data="{ isChecked: false }">

                                        <textarea name="cgv" id="cgv" cols="30" rows="10" class="w-full h-20 p-3 border-gray-50 mt-3 rounded-lg">{{ $cgv->cgv }}</textarea>
                                        <div class="w-full mt-3"><input type="checkbox" id="accept" class="mr-3" x-model="isChecked">J'accepte les CGV et procède au paiement</div>
                                        <button id="card-button"
                                                :disabled="!isChecked"
                                                :class="isChecked ? 'bg-black text-white' : 'bg-gray-400 cursor-not-allowed'"
                                                class="flex flex-1 items-center justify-center mx-auto rounded-lg text-sm w-full bg-black text-white p-3 pl-5 pr-5 align-right mt-6 transition duration-200" data-secret="{{ $intent->client_secret }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="white"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>
                                            <span class="ml-3">Procédez au règlement par CB d'un montant de : {{ $toPay }} € TTC</span>
                                    </button>

                                        @php
                                            // Crée une instance de la date actuelle
                                                $date = new DateTime();

                                                // Ajoute 3 mois à la date actuelle
                                                $date->modify('+3 months');

                                                // Convertit la date modifiée en une chaîne de caractères (optionnel)
                                                $dateString = $date->format('Y-m-d H:i:s');


                                         @endphp

                                    <div class='flex flex-col items-center gap-4 mx-auto mt-6 hidden' id="loader">

                                        <button type='button' class='flex items-center gap-2 py-2.5 px-5 text-sm w-[300px] border border-gray-300 rounded-lg cursor-not-allowed shadow-xs bg-white font-semibold text-gray-900 transition-all duration-500 hover:bg-gray-50 '>
                                            <svg class='w-4 h-4 stroke-indigo-600 animate-spin ' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <g clip-path='url(#clip0_9023_61563_1)'>
                                                    <path d='M14.6437 2.05426C11.9803 1.2966 9.01686 1.64245 6.50315 3.25548C1.85499 6.23817 0.504864 12.4242 3.48756 17.0724C6.47025 21.7205 12.6563 23.0706 17.3044 20.088C20.4971 18.0393 22.1338 14.4793 21.8792 10.9444' stroke='stroke-current' stroke-width='1.4' stroke-linecap='round' class='my-path'></path>
                                                </g>
                                                <defs>
                                                    <clipPath id='clip0_9023_61563_1'>
                                                        <rect width='24' height='24' fill='white'></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>Paiement en cours veuillez patienter... </button>
                                    </div>
                                    </div>

                                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

<script src="https://js.stripe.com/v3/"></script>
<script>



    document.addEventListener('DOMContentLoaded', async () => {
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            document.getElementById('loader').classList.remove("hidden");
            document.getElementById('card-button').classList.add("hidden");

            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        type: 'card',
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                // Display "error.message" to the user... error.type
                alert(error.message + ' Veuillez recommencer votre saisie');
                window.location.reload();
            } else {
                // The card has been verified successfully...
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.appendChild(hiddenInput);

                form.submit();
            }
        });
    });
</script>
</x-layout>
