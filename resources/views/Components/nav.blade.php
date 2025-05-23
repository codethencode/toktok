<nav class="z-10 w-full absolute astro-UY3JLCBK">
    <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
        <div class="flex flex-wrap items-center justify-between py-2 gap-6 md:py-4 md:gap-0 relative astro-UY3JLCBK">
            <input aria-hidden="true" type="checkbox" name="toggle_nav" id="toggle_nav" class="hidden peer astro-UY3JLCBK">
            <div class="relative z-20 w-full flex justify-between lg:w-max md:px-0 astro-UY3JLCBK">
                <a href="/" aria-label="logo" class="flex space-x-2 items-center astro-UY3JLCBK">
                    <div aria-hidden="true" class="flex space-x-1 astro-UY3JLCBK">
                        <div class="h-4 w-4 rounded-full bg-gray-900 dark:bg-white astro-UY3JLCBK"></div>
                        <div class="h-6 w-2 bg-primary astro-UY3JLCBK"></div>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white astro-UY3JLCBK">faciliplaide.fr</span>
                </a>

                <div class="relative flex items-center lg:hidden max-h-10 astro-UY3JLCBK">
                    <label role="button" for="toggle_nav" aria-label="humburger" id="hamburger" class="relative  p-6 -mr-6 astro-UY3JLCBK">
                        <div aria-hidden="true" id="line" class="m-auto h-0.5 w-5 rounded bg-sky-900 dark:bg-gray-300 transition duration-300 astro-UY3JLCBK"></div>
                        <div aria-hidden="true" id="line2" class="m-auto mt-2 h-0.5 w-5 rounded bg-sky-900 dark:bg-gray-300 transition duration-300 astro-UY3JLCBK"></div>
                    </label>
                </div>
            </div>
            <div aria-hidden="true" class="fixed z-10 inset-0 h-screen w-screen bg-white/70 backdrop-blur-2xl origin-bottom scale-y-0 transition duration-500 peer-checked:origin-top peer-checked:scale-y-100 lg:hidden dark:bg-gray-900/70 astro-UY3JLCBK"></div>
            <div class="flex-col z-20 flex-wrap gap-6 p-8 rounded-3xl border border-gray-100 bg-white shadow-2xl shadow-gray-600/10 justify-end w-full invisible opacity-0 translate-y-1  absolute top-full left-0 transition-all duration-300 scale-95 origin-top
                            lg:relative lg:scale-100 lg:peer-checked:translate-y-0 lg:translate-y-0 lg:flex lg:flex-row lg:items-center lg:gap-0 lg:p-0 lg:bg-transparent lg:w-7/12 lg:visible lg:opacity-100 lg:border-none
                            peer-checked:scale-100 peer-checked:opacity-100 peer-checked:visible lg:shadow-none
                            dark:shadow-none dark:bg-gray-800 dark:border-gray-700 astro-UY3JLCBK">

                <div class="text-gray-600 dark:text-gray-300 lg:pr-4 lg:w-auto w-full lg:pt-0 astro-UY3JLCBK">
                    <ul class="tracking-wide font-medium lg:text-sm flex-col flex lg:flex-row gap-6 lg:gap-0 astro-UY3JLCBK">
                        <li class="astro-UY3JLCBK">
                            <a href="#" class="block md:px-4 transition hover:text-primary astro-UY3JLCBK">
                                <span class="astro-UY3JLCBK">Notre solutions</span>
                            </a>
                        </li>
                             <li class="astro-UY3JLCBK">
                            <a href="#" class="block md:px-4 transition hover:text-primary astro-UY3JLCBK">
                                <span class="astro-UY3JLCBK">Sécurité & fonctionnalité</span>
                            </a>
                        </li>
                        <li class="astro-UY3JLCBK">
                            <a href="#" class="block md:px-4 transition hover:text-primary astro-UY3JLCBK">
                                <span class="astro-UY3JLCBK">Blog</span>
                            </a>
                        </li>

                        @auth
                            {{-- Auth::user()->email; --}}

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <li class="astro-UY3JLCBK">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            </li>

                        @endauth

                    </ul>
                </div>




                <div class="mt-12 lg:mt-0 astro-UY3JLCBK">
                    @auth
                        {{-- Auth::user()->email; --}}

                                       <a href="/account" class="relative flex h-9 w-full items-center justify-center px-4 before:absolute before:inset-0 before:rounded-full before:bg-blue-500 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max astro-UY3JLCBK">

                            <span class="relative text-sm font-semibold text-white astro-UY3JLCBK">Mon compte</span>
                        </a>
                    @elseguest
                        <a href="/login/account" class="relative flex h-9 w-full items-center justify-center px-4 before:absolute before:inset-0 before:rounded-full before:bg-blue-500 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max astro-UY3JLCBK">
                            <span class="relative text-sm font-semibold text-white astro-UY3JLCBK">Se connecter</span>
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</nav>
