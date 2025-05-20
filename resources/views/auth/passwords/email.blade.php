<x-layout>

    <main class="space-y-40 mb-40">

        <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
            <div class="relative sm:pt-3 md:pt-36 ml-auto">
                <div class="lg:w-3/4 text-center mx-auto">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card max-w-2xl mx-auto">
                    <div class="card-header">{{ __('Réinitialiser le mot de passe') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="bg-green-500 rounded-lg p-3 mt-4 mb-4 text-white" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf


                            <div class="mt-8">
                                <x-input-label for="email" :value="__('Renseignez votre Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

{{--                            <div class="form-group row">--}}
{{--                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse e-mail') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                    @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4 mt-3 p-3 text-white bg-purple-400 rounded-lg">
                                    <button type="submit" class="bg-purple-400">
                                        {{ __('Envoyer le lien de réinitialisation du mot de passe') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

                </div>
            </div>
        </div>
    </main>

</x-layout>
