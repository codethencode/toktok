<x-layoutAdmin>
    <x-slot name="title">Liste des clients</x-slot>

    <div class="max-w-6xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">Clients</h1>

        <div class="mb-4 text-right text-md text-gray-600">
            <strong>💶 Total CA généré :</strong>
            {{ number_format($totalCA, 2, ',', ' ') }} €
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nom</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Téléphone</th>
                    <th class="p-2 border">Google ?</th>
                    <th class="p-2 border text-center">Commandes payées</th>
                    <th class="p-2 border text-right">Total payé (€)</th>
                    <th class="p-2 border text-center">Commandes non payées</th>
                    <th class="p-2 border text-center">Abonnements</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td class="p-2 border">{{ $client['name'] }}</td>
                        <td class="p-2 border">{{ $client['email'] }}</td>
                        <td class="p-2 border">{{ $client['phone'] }}</td>
                        <td class="p-2 border text-center">{{ $client['is_google'] ? '✅' : '❌' }}</td>
                        <td class="p-2 border text-center">{{ $client['paid_count'] }}</td>
                        <td class="p-2 border text-right">{{ number_format($client['paid_total'], 2, ',', ' ') }}</td>
                        <td class="p-2 border text-center">{{ $client['unpaid_count'] }}</td>
                        <td class="p-2 border text-center">{{ $client['abo_count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $clients->links() }}
        </div>
        <div class="pt-5">
        <a href="/account" class="bg-gray-800 p-2 text-sm pl-5 pr-5 mt-5 text-white rounded-md">Retour</a>
        </div>    
    </div>
</x-layoutAdmin>