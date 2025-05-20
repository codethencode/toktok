<x-layout>

    <main class="space-y-40 mb-40">

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative sm:pt-3 md:pt-36 ml-auto">
                <div class="lg:w-3/4 text-center mx-auto">

                    <div class="flex items-center justify-center">
                        <div class="w-full max-w-md">
                            <div class="bg-white rounded-lg px-8 py-6">
                                <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">{{ __('Réinitialiser le mot de passe') }}</h2>

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Adresse e-mail') }}</label>
                                        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('email') border-red-500 @enderror">

                                        @error('email')
                                        <p class="text-red-500 text-xs mt-1">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Nouveau mot de passe') }}</label>
                                        <input id="password" type="password" name="password" required autocomplete="new-password"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-xl tracking-wider @error('password') border-red-500 @enderror">

                                        @error('password')
                                        <p class="text-red-500 text-xs mt-1">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirmez le mot de passe') }}</label>
                                        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-xl">

                                    </div>

                                    <div class="items-center rounded-lg text-white bg-blue-500">
                                        <button type="submit" class="text-white font-semibold py-2 px-4 rounded-lg">
                                            {{ __('Réinitialiser le mot de passe') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layout>
