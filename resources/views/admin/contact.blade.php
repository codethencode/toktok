<x-layout>
    <section class="max-w-5xl mx-auto px-6 py-16">
        <h1 class="text-3xl font-bold mb-8">Messages de contact</h1>
        <div class="space-y-6">
            @foreach($messages as $msg)
                <div class="p-4 bg-white shadow rounded-lg border">
                    <div class="font-semibold">{{ $msg->nom }} ({{ $msg->email }})</div>
                    <div class="text-sm text-gray-500 mb-2">📞 {{ $msg->telephone ?? 'Non renseigné' }}</div>
                    <p class="text-gray-700">{{ $msg->message }}</p>
                    <div class="text-right text-xs text-gray-400">{{ $msg->created_at->format('d/m/Y H:i') }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $messages->links() }}
        </div>
    </section>
</x-layout>