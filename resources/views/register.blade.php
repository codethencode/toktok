<x-layout>

    <main class="space-y-40 mb-40">
        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative pt-20 sm:pt-3 md:pt-36 ml-auto">
                <div class="lg:w-3/4 text-center mx-auto dark:text-white">
Ce service est réservé aux avocats et cabinets d'avocats.<br>Afin de calculer très rapidement votre tarif et d'accéder à nos services merci de créer votre compte ou de vous authentifier.
                    <div class="grid sm:grid-col-1 md:grid-cols-2 gap-1 pt-10 mb-10 pl-5 pr-5">
                        <div class="flex-1 text-left items-left break-words md:pr-16 mb-10">
                            Nouveau membre ?<br><br>


                            <a href="{{ route('auth.google.redirect') }}"
                            class="w-full dark:text-gray-800 flex items-center justify-center px-4 py-3 mb-4 border border-gray-300 rounded shadow hover:bg-gray-50">
    <img src="/images/google-com.svg" class="w-5 h-5 mr-2" alt="Google logo">
    <span>Continuer avec Google</span>
</a>

<div class="text-center text-gray-400 text-sm mb-4">ou</div>

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



                        <div class="justify-center text-left items-left">
                            @if (\Session::has('success'))
                                <div class="bg-green-300">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif

                            Dejà membre ?<br><br>

                            <a href="{{ route('auth.google.redirect') }}" class="w-full dark:text-gray-800 flex items-center justify-center px-4 py-3 mb-4 border border-gray-300 rounded shadow hover:bg-gray-50">
    <img src="/images/google-com.svg" class="w-5 h-5 mr-2" alt="Google logo">
    <span>Se connecter avec Google</span>
</a>

<div class="text-center text-gray-400 text-sm mb-4">ou</div>
                            <!-- Email Address -->
                            <form method="POST" action="/login">
                                @csrf
                                
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
                                <a href="/password/forgot"><span class="text-sm text-right">Mot de passe oublié ?</span></a>
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
