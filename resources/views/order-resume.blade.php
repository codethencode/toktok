 <x-layout>

    <main class="space-y-40 mb-40">

        <div class="relative">

            <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
                <div class="relative sm:pt-3 md:pt-36 ml-auto">
                    <div class="lg:w-3/4 text-center mx-auto">


                        <div class="grid sm:grid-col-1 md:grid-cols-1 gap-1 pt-10 md:space-x-5 xs:space-y-5" >
                            <div class="flex-1 text-left items-left break-words mt-10 sm:mt-5 mb-10">
                                <div class="bg-blue-200 p-5 rounded-lg pl-10 pr-10 ">

                    Ville où l'avocat déposera votre dossier :  <strong>{{ strtoupper($city) }}</strong><br>
                    Nombre de pages de votre dossier : <strong>{{ $numberOfPages }}</strong><br>
                    Type Impression : <strong>{{ strtoupper($getImpression) }}</strong><br>
                    Type Reliure : <strong>{{ strtoupper($getReliure) }}</strong><br>
                    Expédition : <strong>{{ strtoupper($getExpe) }}</strong><br>
                    <br>
                        @if($member==="on")
                            Option Membre (abonnement mensuel) : <strong>OUI</strong><br>
                            Dossier : <strong>{{ $totalPrice }} € HT soit {{ $totalPrice*1.2 }} € TTC</strong><br>
                            Abonnement mensuel : <strong>29 € HT soit {{ 29*1.2 }} € TTC</strong><br>
                            -----<br>
                            Total à régler : <strong>{{ number_format(($totalPrice*1.2)+(29*1.2), 2, '.', ',') }} € TTC</strong>
                            @php $totalToPay = number_format(($totalPrice*1.2)+(29*1.2), 2, '.', ','); @endphp
                        @else
                            Option Membre (abonnement mensuel) : <strong>NON</strong><br>
                            Total à régler : <strong>{{ $totalPrice }} € HT soit {{ $totalPrice*1.2 }} € TTC</strong>
                            @php $totalToPay = number_format($totalPrice*1.2, 2, '.', ','); @endphp
                        @endif


                    </div>

                      <div class="grid sm:grid-col-1 md:grid-cols-1 gap-1" >
                          <div class="text-left items-left break-words mt-5">
                              <div class="bg-purple-200 rounded-lg p-10">



                              <form method="POST" action="payment">
                                  @csrf

                                  <input type="hidden" name="city" value="{{ $city }}" />
                                  <input type="hidden" name="printType" value="{{ $printType }}" />
                                  <input type="hidden" name="reliureQuality" value="{{ $reliureQuality }}">
                                  <input type="hidden" name="expeType" value="{{ $expeType }}">
                                  <input type="hidden" name="numberOfPages" value="{{ $numberOfPages }}">
                                  <input type="hidden" name="toPay" value="{{ $totalToPay }}">
                                  <input type="hidden" id="totalPriceHidden" name="totalPrice" x-bind:value="totalPrice">
                                      <x-button class="bg-black" id="totalGen7" >Procéder au paiement de <strong>{{ $totalToPay }} € TTC par CB</strong></x-button>

                              </form>
                              </div>
                          </div>
                      </div>

                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layout>
