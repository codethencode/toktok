<x-layout>
   
    <main class="space-y-40 mb-40">

       
        <div class="max-w-screen-xl mx-auto px-6 md:px-12 xl:px-6">

                    <div class="relative sm:pt-3 md:pt-36 ml-auto">
                <div class="text-center mx-auto">

                    @if(session('status'))
                        <div class="bg-green-300 p-3 rounded-md mb-4">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div class="flex space-x-3 text-sm mb-10">
                    @auth
                    Vous êtes connecté à votre compte : {{ Auth::user()->email; }}
                        
                        @if (Auth::user() && Auth::user()->role=='admin')
                            [ Compte Admin ]
                        @endif
                   
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
                                <div class="flex items-center justify-center h-16 w-full bg-purple-500 text-white rounded-lg text-center px-3">
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
    <div class="flex items-center justify-center h-16 w-full bg-gray-800 text-white rounded-lg text-center px-3 flex-1">
        Abonnement mensuel résiliable à partir du {{ $cancelDateFormatted }}
    </div>
@endif
                    </div>
                    



                        
                    <hr class="mt-5 mb-5">

                    Mes achats ({{ $orderAll->count() }})<br>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 table-striped text-sm">
                            <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Num</th>
                                <th class="py-2 px-4 border-b">Num Cde.</th>
                                <th class="py-2 px-4 border-b">Votre Référence</th>
                                <th class="py-2 px-4 border-b">Prix TTC</th>
                                <th class="py-2 px-4 border-b">Date Cde</th>
                                <th class="py-2 px-4 border-b">Nb de page dossier</th>
                                <th class="py-2 px-4 border-b">Option Plaidoirie</th>
                                <th class="py-2 px-4 border-b">Etat d'avancement</th>
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
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-blue-100' : 'bg-white' }} hover:bg-green-200 cursor-pointer">
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
                            <td class="py-4 px-4 border-b"><div class="text-xs text-white bg-gray-900 rounded-lg p-2 h-[50px]">{{ strtoupper($order->order_name) }}</div></td>
                            <td class="py-2 px-4 border-b">{{ $order->total_price }} € TTC</td>
                            <td class="py-2 px-4 border-b">{{ $date->translatedFormat('l d F Y à H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->numberOfPages }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->plaidoirie->label }}</td>

                            @php
                                if($order->step === null) { $step = 'envoiFichier-01'; }
                            else
                                { $step =  $order->step->step; }
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

                            <td class="py-2 px-4 border-b"> <button class="text-xs text-white {{ $color }} rounded-lg p-2 h-[50px] w-[50px]">
                                {{ $step }}/5</button></td>
                            <td class="py-2 px-4 border-b">

                                <div class="flex flex-col space-y-3 w-56">
                                    @if($step < 4)
                                        <form method="post" action="uploadfile">
                                            @csrf
                                            <input type="hidden" name="directory" value="{{ str_replace('cus_', '', $order->stripe_customer_id).'-'.$order->order_id }}">
                                            <input type="hidden" name="order_name" value="{{ $order->order_name }}">
                                            <button type="submit" class="custom-button text-xs text-white bg-purple-700 rounded-lg p-2 w-full">
                                                Instruire mon Dossier
                                            </button>
                                        </form>
                                    @endif
                                
                                    @if($step == 4)
                                        <a href="{{ route('account.enterAddress', ['order_id'=> $order->order_id, 'uid'=> Auth::user() ]) }}">
                                            <button class="bg-gray-900 text-white py-2 px-4 rounded w-full">
                                                Suivant
                                            </button>
                                        </a>
                                    @endif
                                
                                    <a href="{{ route('account.orders.detail', ['orderId' => $order->order_id]) }}"
                                       class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition w-full">
                                        Voir le détail
                                    </a>
                                
                                    @if(!empty($order->company?->name) && !empty($order->company?->adresse))
                                        <a href="{{ route('account.orders.invoice', ['orderId' => $order->order_id]) }}"
                                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition w-full">
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
