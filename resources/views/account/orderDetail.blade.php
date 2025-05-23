<x-layout>

    <main class="space-y-40 mb-40">

       

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative sm:pt-3 md:pt-36 ml-auto">


 <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-xl">
    <h1 class="text-2xl font-bold mb-6">Détail de la commande {{ $basket->order_id }}</h1>

    <table class="w-full table-auto border border-gray-300 text-sm">
        <tbody class="divide-y divide-gray-200">

            <tr>
                <td class="p-3 font-medium">Frais de mise en service</td>
                <td class="p-3 text-right">{{ number_format($basket->baseFeePrice, 2) }} €</td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Nombre de pages</td>
                <td class="p-3 text-right">{{ $basket->numberOfPages }}</td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Type d'impression</td>
                <td class="p-3 text-right">
                    {{ $typeImpression->label ?? 'N/A' }} ({{ number_format($typeImpression->price ?? 0, 2) }} € x {{ $basket->numberOfPages }})<br>
                    = {{ number_format($basket->numberOfPages * ($typeImpression->price ?? 0), 2) }} €
                </td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Type de reliure</td>
                <td class="p-3 text-right">{{ $typeReliure->label ?? 'N/A' }} - {{ number_format($typeReliure->price ?? 0, 2) }} €</td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Plaidoirie</td>
                <td class="p-3 text-right">
                    <div class="font-semibold">{{ $plaidoirie->label ?? 'N/A' }} - {{ number_format($plaidoirie->price ?? 0, 2) }} €</div>
                    <div class="text-gray-500 italic">{{ $plaidoirie->description ?? '' }}</div>
                </td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Juridiction</td>
                <td class="p-3 text-right">
                    <div class="font-semibold">{{ $juridiction->label ?? 'N/A' }} - {{ number_format($juridiction->price ?? 0, 2) }} €</div>
                    <div class="text-gray-500 italic">{{ $juridiction->description ?? '' }}</div>
                </td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Zone géographique</td>
                <td class="p-3 text-right">{{ $zoneGeo->label ?? 'N/A' }} - {{ number_format($zoneGeo->price ?? 0, 2) }} €</td>
            </tr>

            <tr>
                <td class="p-3 font-medium">Option urgence</td>
                <td class="p-3 text-right">
                    
                    
                    {{ $basket->isUrgent === 'true' ? 'Oui' : 'Non' }}
                    
                    @if($basket->urgentPrice >0 )
                        - {{ number_format($basket->urgentPrice ?? 0, 2) }} €
                    @endif
                </td>
            </tr>

            <tr class="bg-gray-100 font-bold">
                <td class="p-3 text-lg">Total</td>
                
              
                <td class="p-3 text-lg text-right">{{ number_format($basket->total_price / 1.2, 2) }} € HT soit {{ number_format($basket->total_price, 2)}} € TTC</td>
              
            </tr>

        </tbody>
    </table>
</div>

</main>
</x-layout>