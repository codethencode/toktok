<x-layout>
   
    <main class="space-y-40 mb-40">
        
          
        <div class="max-w-screen-xl mx-auto px-6 md:px-12 xl:px-6">

            <div class="relative sm:pt-3 md:pt-36 pt-20 ml-auto">
                <div class="text-center mx-auto">

                    @if(session('status'))
                        <div class="bg-green-300 p-3 rounded-md mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="mb-10 text-sm space-y-3">
                        @auth
                            <div class="text-center mb-5 dark:text-white">
                                Vous êtes connecté à votre compte : 
                                <strong>{{ Auth::user()->name }}</strong> | 
                                <strong>{{ Auth::user()->email }}</strong> | 
                                <strong>Tél. {{ Auth::user()->phone === '00000' ? 'Non renseigné ' : Auth::user()->phone }}</strong> | 
                                <a href="/profil">Mettre à jour mon compte</a>
                    
                                @if (Auth::user()->role === 'admin')
                                    <button class="ml-2 bg-red-200 pt-1 pb-1 rounded-md pl-3 pr-3 text-red-600">Administrateur</button>
                                        @if (Auth::user()->email === 'info@jaihk.fr')
                                        <a href="/admin/clients"><button class="ml-2 bg-gray-200 pt-1 pb-1 rounded-md pl-3 pr-3 text-gray-800">Stats Clients</button></a>
                                        <a href="/admin/options"><button class="ml-2 bg-green-200 pt-1 pb-1 rounded-md pl-3 pr-3 text-gray-800">Tarifs Options</button></a>
                                        @endif
                                @endif
                            </div>
                    
                            
                    
                            <div class="flex justify-center mt-10">
                                <form method="POST" action="{{ route('account.orders.search') }}"
                                    class="flex flex-col-1 sm:flex-row gap-2 items-start sm:items-center">
                                    @csrf

                                    @if (Auth::check() && Auth::user()->role === 'admin')
                                     <input type="text" name="search" value="{{ old('search') }}"
                                        placeholder="Num cde ou Email ou Réf."
                                        class="border border-gray-200 rounded-md p-2 text-sm w-full sm:w-64">
                                    @else
                                    <input type="text" name="search" value="{{ old('search') }}"
                                        placeholder="Num. commande ou Réf. dossier"
                                        class="border border-gray-200 rounded-md p-2 text-sm w-full sm:w-64">
                                    @endif

                                    <button type="submit"
                                        class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-md hover:bg-yellow-600 transition"
                                        style="background-color:rgb(218, 191, 71)">
                                        Rechercher
                                    </button>

                                      <a href="/account"><button 
                                        class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-md hover:bg-yellow-600 transition"
                                        style="background-color:rgb(242, 232, 189)">
                                        Réinitialiser
                                    </button></a>

                                </form>
                            </div>
                        @endauth
                    </div>
                    
                  




                    <div class="flex space-x-3 text-sm">
                        <!-- Bouton 1 -->
                        <a href="order-init" class="flex-1">
                            <div class="flex items-center justify-center h-16 w-full bg-green-600 text-white rounded-lg text-center px-3">
                                Commander une nouvelle prestation de dépôt de dossier
                            </div>
                        </a>
                    
                        <!-- Bouton 2 -->
                        @if($checkAbo != 'nonAbo' && $checkAbo->stripe_status === 'active')
                            <a href="order-init" class="flex-1">
                                <div class="flex items-center justify-center h-16 w-full bg-gray-800 text-white rounded-lg text-center px-3">
                                    Statut membre : vous bénéficiez de 15% de remise sur le site
                                </div>
                            </a>
                        @endif
                    
                        <!-- Bouton 3 : Résiliation -->
                     
                    
                        @php
    $currentDate = \Carbon\Carbon::now();
    $canCancel = false;
    $cancelDateFormatted = null;

    if ($checkAbo !== 'nonAbo' && is_object($checkAbo) && $checkAbo->created_at) {
        $dateReference = $checkAbo->created_at;
        $dateAfterThreeMonths = $dateReference->copy()->addMonths(3);
        $cancelDateFormatted = $dateAfterThreeMonths->format('d/m/Y');

        $canCancel = $currentDate->greaterThanOrEqualTo($dateAfterThreeMonths);
    }
@endphp

@if($canCancel)
    <form method="POST" action="cancelSubs" class="flex-1">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <button type="submit" class="custom-button flex items-center justify-center h-16 w-full bg-red-500 text-white rounded-lg text-center px-3">
            Résilier mon abonnement mensuel dès à présent et stopper mes prélèvements de 29 € / mois
        </button>
    </form>
@elseif($cancelDateFormatted)
    <div class="flex items-center justify-center h-16 w-full bg-purple-600 text-white rounded-lg text-center px-3 flex-1">
        Abonn. mensuel 29 € TTC / mois résiliable à partir du {{ $cancelDateFormatted }}
    </div>
@endif
                    </div>
                    



                        
                    <hr class="mt-5 mb-5">

                    <span class="dark:text-white">Mes achats ({{ $orderAll->count() }})</span><br>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 table-striped text-sm">
                            <thead>
                            <tr>
                                <th class="py-2 px-4 border-b dark:text-white">Num</th>
                                <th class="py-2 px-4 border-b dark:text-white">Num Cde.</th>
                                <th class="py-2 px-4 border-b dark:text-white">N° Affaire</th>
                                <th class="py-2 px-4 border-b dark:text-white">Prix TTC</th>
                                <th class="py-2 px-4 border-b dark:text-white">Date Cde</th>
                                <th class="py-2 px-4 border-b dark:text-white">Nb de page dossier</th>
                                <th class="py-2 px-4 border-b dark:text-white">Option Plaidoirie</th>
                                <th class="py-2 px-4 border-b dark:text-white">Etat d'avancement</th>
                            <th class="py-2 px-4 border-b">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                    @foreach($orderAll as $order)
                        @php
                            // Assurez-vous que Carbon utilise la locale française
                            \Carbon\Carbon::setLocale('fr');

                            // Convertir la date en instance Carbon
                            $date = \Carbon\Carbon::parse($order->created_at);
                        @endphp



{{--                        <tr>--}}
{{--                            <td colspan="8">--}}
{{--                                <div class="w-full bg-gray-200 rounded-lg h-4">--}}
{{--                                    <div class="bg-blue-600 h-full rounded-lg" style="width: 80%;"></div>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
                            <tr><td colspan='9'>&nbsp;</td></tr>
                            @if($order->isUrgent == 'true' && $order->remainingTime)
                            <tr><td colspan='9' class='bg-red-400'><div class="text-sm  {{ Str::contains($order->remainingTime, 'dépassé') ? 'text-white font-bold' : 'text-white' }}">
                                DOSSIER URGENT ! 
                                
                                @if($isAdmin === true) {{ $order->remainingTime }} @endif
                                
                                Validé le : {{ \Carbon\Carbon::parse($order->dateValidSend)->translatedFormat('d F Y à H\hi') }}
                            </div></td>
                            </tr>
                            @else
                                @if(($order->validSend=='validSent')&&(optional($order->dossierCustomer)->step === 'envoiFichier-04'))
                                <tr><td colspan='9' class='bg-green-100'><div class="text-sm text-green-700 font-bold">
                                Vous avez validé votre DOSSIER pour envoi le : {{ \Carbon\Carbon::parse($order->dateValidSend)->translatedFormat('d F Y à H\hi') }}
                                </div></td>
                                </tr>
                                @endif
                            
                            @endif

                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-blue-100' : 'bg-white' }} hover:bg-gray-200 cursor-pointer">
                            <td class="py-4 px-4 border-b">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4 border-b">{{ $order->order_id }}

                                
                            @if($isAdmin === true)
                                <hr>
                                <br>{{ $order->customer->name }}
                                <br>{{ $order->customer->phone }}
                                <br>{{ $order->customer->email }}
                                <br><br>
                                @php
                                    if($order->isAbo === "abo")
                                        {
                                        echo "<div class='p-1 rounded-full text-white text-xs bg-green-600'>Abonné</div>";
                                        }
                                    else
                                        {
                                        echo "<div class='p-1 rounded-full text-white text-xs bg-gray-800'>Non Abonné</div>";
                                        }
                                @endphp

                            @endif
                            </td>
                            <td class="py-4 px-4 border-b">
                                <div x-data="{ showConfirm: false }" class="flex items-start gap-2 flex-wrap justify-center relative">
                            
                                    <!-- Nom du dossier -->
                                    <div class="text-xs text-white bg-gray-900 hover:bg-gray-500 rounded-lg p-2 w-32 text-center">
                                        {{ strtoupper($order->order_name) }}
                                    </div>
                            
                                    
                                    @if($isAdmin && $order->validSend === 'validSent')
                                    {{-- @if(($isAdmin === true) && ($order->hasFiles)) --}}
                                        <!-- Bouton Reset -->
                                        {{-- @if(optional($order->dossierCustomer)->step === 'envoiFichier-04') --}}
                                        <button @click="showConfirm = true"
                                                class="bg-yellow-500 text-gray-900 hover:bg-yellow-300 rounded-lg p-2 text-xs w-32">
                                            Reset Dossier
                                        </button>
                                        {{-- @endif --}}
                            
                                        <!-- Bouton À traiter -->
                                        

                                       @if($order->validSend === 'validSent' && $order->stepFromDossier === 'envoiFichier-04')
                                            <a href="{{ route('account.enterAddress', ['order_id'=> $order->order_id, 'uid'=> Auth::user() ]) }}">
                                                <button class="bg-orange-400 hover:bg-orange-200 text-gray-900 rounded-lg p-2 text-xs w-32">
                                                    À traiter
                                                </button>
                                            </a>
                                        @endif
                            
                                        <!-- Modale de confirmation -->
                                        <div x-show="showConfirm"
                                             x-transition
                                             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                             style="display: none;">
                                            <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md">
                                                <h2 class="text-lg font-semibold mb-4">Confirmation</h2>
                                                <p class="text-sm text-gray-700 mb-6">
                                                    Réinitialiser le dossier permettra de télécharger de nouveaux fichiers.<br>
                                                    Souhaitez-vous continuer ?
                                                </p>
                                                <div class="flex justify-end gap-3">
                                                    <!-- Annuler -->
                                                    <button @click="showConfirm = false"
                                                            class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400">
                                                        Annuler
                                                    </button>
                            
                                                    <!-- Confirmer -->
                                                    <form method="POST" action="{{ route('dossier.reset', ['order_id' => $order->order_id]) }}">
                                                        @csrf
                                                        <button type="submit"
                                                                class="px-4 py-2 rounded bg-yellow-500 text-gray-900 hover:bg-yellow-600 font-semibold">
                                                            Confirmer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            
                                </div>
                            </td>
                            
                            <td class="py-2 px-4 border-b">{{ $order->total_price }} € TTC</td>
                            <td class="py-2 px-4 border-b">{{ $date->translatedFormat('l d F Y à H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->numberOfPages }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->plaidoirie->label }}</td>

                            
                            @php
                                if($order->dossierCustomer === null) { $step = 'envoiFichier-01'; }
                            else
                                { $step =  $order->dossierCustomer->step; }
                               $step = substr($step,-1);

                                if($step == 1) {
                                    $color = 'bg-blue-500';
                                } elseif($step == 2) {
                                    $color = 'bg-yellow-500';
                                } elseif($step == 3) {
                                    $color = 'bg-orange-600';
                                } elseif($step == 4) {
                                    $color = 'bg-gray-900';
                                } else {
                                    $color = 'bg-green-600';
                                }
                          @endphp

                            <td class="py-2 px-4 border-b">
                                @if($step == 'd')
                                <button class="text-xs text-white {{ $color }} rounded-lg p-2 h-[50px] w-[50px]">Traité</button>
                                @else
                                <button class="text-xs text-white {{ $color }} rounded-lg p-2 h-[50px] w-[50px]">{{ $step }}/5</button>
                                @endif
                            </td>
                            <td class="py-8 px-4 border-b">

                                <div class="flex flex-col space-y-3 w-56">
                                    @if($step < 4)
                                        <form method="post" action="/uploadfile">
                                            @csrf
                                            <input type="hidden" name="directory" value="{{ str_replace('cus_', '', $order->stripe_customer_id).'-'.$order->order_id }}">
                                            <input type="hidden" name="order_name" value="{{ $order->order_name }}">
                                            <button type="submit" class="custom-button text-xs text-white hover:bg-purple-400 bg-purple-700 rounded-lg p-2 w-full">
                                                Instruire mon Dossier
                                            </button>
                                        </form>
                                    @endif
                                
                                    @if($step >= 4)
                                        <a href="{{ route('account.enterAddress', ['order_id'=> $order->order_id, 'uid'=> Auth::user() ]) }}">
                                            <button class="bg-gray-900 text-white py-2 px-4 rounded-lg text-xs hover:bg-gray-600 w-full">
                                                Mon dossier
                                            </button>
                                        </a>
                                    @endif
                                
                                    <a href="{{ route('account.orders.detail', ['orderId' => $order->order_id]) }}"
                                       class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition w-full">
                                        Détail commande
                                    </a>
                                
                                    @if(!empty($order->company?->name) && !empty($order->company?->adresse))
                                        <a href="{{ route('account.orders.invoice', ['orderId' => $order->order_id]) }}"
                                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-700 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition w-full">
                                            Télécharger Facture PDF
                                        </a>
                                    @endif
                                </div>
                                


                            </td>



                        </tr>

                       

                    @endforeach
                            </tbody>
                        </table>

                    </div>

                        <div class="mt-7">
                        {{ $orderAll->links() }}
                        </div>
{{--            <p class="mt-10">--}}
{{--                    <h1 class="text-xl font-bold mb-4">Orders JSON</h1>--}}
{{--                    <pre class="bg-gray-200 p-4 rounded">--}}
{{--                     {{ json_encode($orderAll, JSON_PRETTY_PRINT) }}--}}
{{--                    </pre>--}}
{{--            </p>--}}

                </div>



            </div>


        </div>



    </main>

</x-layout>
