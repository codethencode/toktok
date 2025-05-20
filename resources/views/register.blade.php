<x-layout>

    <main class="space-y-40 mb-40">

        @auth
            Logged ! {{ Auth::user()->email; }}
        @endauth

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative sm:pt-3 md:pt-36 ml-auto">
                <div class="lg:w-3/4 text-center mx-auto">

                    <div class="grid sm:grid-col-1 md:grid-cols-2 gap-1 pt-10">
                        <div class="flex-1 text-left items-left break-words pl-10 md:pr-16 pt-5">
                            Nouveau membre ?<br>
                            <form method="POST" action="/register">
                                @csrf
                                <div class="mt-4">
                                    <x-input-label for="name" :value="__('Nom*')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                <x-input-label for="title" :value="__('Mail*')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Mot de passe*')" />
                                <x-text-input id="password" class="block mt-1 w-full p-0 pl-3 text-3xl" type="password" name="password" :value="old('password')" required autocomplete="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirmez votre mot de passe*')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full p-0 pl-3 text-3xl" type="password" name="password_confirmation" :value="old('password_confirmation')" required autocomplete="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="phone" :value="__('Téléphone*')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div class="pr-3">
                                <x-button class="bg-blue-500 mt-6">Déposer mon dossier à partir de 129€ HT</x-button>
                            </div>
                            </form>
                        </div>
                        <!-- ... -->



                        <div class="sm:pl-10 md:pl-16 p-5 justify-center text-left items-left">
                            @if (\Session::has('success'))
                                <div class="bg-green-300">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif

                            Dejà membre ?<br>
                            <!-- Email Address -->
                            <form method="POST" action="/login">
                                @csrf
                                {{ $action }}
                            <input type="hidden" name="action" value="{{ $action }}">
                            <div class="mt-4">
                                <x-input-label for="login-email" :value="__('Email')" />
                                <x-text-input id="login-email" class="block mt-1 w-full" type="text" name="login-email" :value="old('login-email')" required autocomplete="login-email" />
                                <x-input-error :messages="$errors->get('login-email')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <x-input-label for="login-password" :value="__('Mot de Passe')" />
                                <x-text-input id="login-password" class="block mt-1 p-0 w-full pl-3 text-3xl" type="password" name="login-password" :value="old('login-password')" required autocomplete="login-password" />
                                <x-input-error :messages="$errors->get('login-password')" class="mt-2" />
                            </div>
                                <div class="text-right">
                                <a href="password/forgot"><span class="text-sm text-right">Mot de passe oublié ?</span></a>
                                </div>
                                    <div class="mt-4">
                                <x-button class="bg-blue-500">Login</x-button>
                            </div>
                            </form>
                         </div>
                    </div>

                 </div>
            </div>
        </div>
    </main>

</x-layout>
