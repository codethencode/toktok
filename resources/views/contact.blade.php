<x-layout>
  <section class="py-24 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 opacity-30 pointer-events-none"></div>

    <div class="relative max-w-3xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-6">Contactez-nous</h2>
        <p class="text-center text-gray-600 mb-12">Une question, une demande sur mesure ? Écrivez-nous via ce formulaire.</p>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 rounded-lg px-4 py-3 text-sm mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Honeypot -->
            <input type="text" name="honeypot" class="hidden" aria-hidden="true">

            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('nom') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}" required
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('telephone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="5" required
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('message') }}</textarea>
                @error('message') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit"
                        class="custom-button bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-blue-700 transition">
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</section> 
</x-layout>