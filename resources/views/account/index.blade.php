<x-layout>

    <main class="space-y-40 mb-40">

       

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative sm:pt-3 md:pt-36 ml-auto">
                <div class="lg:w-3/4 text-center mx-auto">

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
                            <a href="order-init" class="flex-1">
                                <button class="bg-green-600 text-white p-3 rounded-lg w-full">
                                    Commander une nouvelle prestation de dépôt de dossier
                                </button>
                            </a>


                            @if($checkAbo!='nonAbo')

                            @if($checkAbo->stripe_status === 'active')
                                <a href="order-init" class="flex-1">
                                    <button class="bg-purple-500 text-white p-3 rounded-lg w-full">
                                        Statut membre vous bénéficiez de 15% de remise sur le site
                                    </button>
                                </a>
                            @endif

                            @php

                                $dateReference = $checkAbo->created_at;
                                $dateAfterThreeMonths = $dateReference->addMonths(3);
                                $currentDate = Carbon\Carbon::now();

                                    if ($currentDate->greaterThanOrEqualTo($dateAfterThreeMonths)) {
                                        echo "<form method='post' action='cancelSubs' class='flex-1'>";
                                        echo csrf_field();
                                        echo "<input type='hidden' name='user_id' value=1>";
                                        echo "<button type='submit' class='custom-button bg-red-500 text-white p-3 rounded-lg w-full'>Résilier mon abonnement mensuel dès à présent et stopper mes prélèvements de 29 € / mois</button>";
                                        echo "</form>";
                                        $message = "";
                                                }
                                                else
                                                {
                                                $message = "<div class='bg-gray-800 p-3 text-white rounded-lg flex-1'>Abonnement mensuel résiliable à partir de 3 mois de souscription : ".$dateAfterThreeMonths."</div>";
                                                }
                    @endphp
                    {!! $message !!}
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
                            <td class="py-2 px-4 border-b">{{ $order->plaidoirie->libelle }}</td>

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

                                @if($step<4)
                                <form method="post" action="uploadfile">
                                    @csrf
                            <input type="hidden" name="directory" value="{{ str_replace('cus_', '',$order->stripe_customer_id).'-'.$order->order_id  }}">
{{--                                    <input type="hidden" name="directory" value="684-338-291">--}}
                                    <button type="submit" class="custom-button text-xs text-white bg-purple-700 rounded-lg p-2">Instruire mon Dossier</button>
                                </form>
                                @endif

                                @if($step==4)

                                <a href="{{ route('account.enterAddress', ['order_id'=> $order->order_id, 'uid'=> Auth::user() ]) }}">
                                    <button class="bg-gray-900 text-white py-2 px-4 rounded">Suivant</button>
                                </a>
                                    @endif

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
