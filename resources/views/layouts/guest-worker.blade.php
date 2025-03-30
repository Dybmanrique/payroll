<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Livewire Styles -->
    @livewireStyles
    @yield('css')
    @stack('css')
</head>

<body class="bg-gray-100 flex flex-col h-screen justify-between">
    <header class="text-white bg-blue-950">

        <div class="flex items-center py-4">
            <div class="text-right w-1/3">
                <img src="{{ asset('img/logo.png') }}" alt="Descripción" class="w-20 inline-block">
            </div>
            <div class="flex-grow ml-4 w-2/3">
                <h1 class="font-bold text-2xl md:text-4xl">SISTEMA DE PLANILLAS</h1>
                <p class="sm:block hidden text-xl">UNIDAD DE GESTIÓN EDUCATIVA LOCAL DE ASUNCIÓN</p>
                <p class="sm:hidden block text-xl">UGEL ASUNCIÓN</p>
            </div>
        </div>

    </header>
    <nav class="sm:block hidden bg-gray-900 text-white text-right sticky top-0 z-10">
        <ul class="m-0 px-3">
            @auth('worker')
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 my-2 py-2 border border-transparent text-md leading-4 rounded-md text-gray-100 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ auth('worker')->user()->name }} {{ auth('worker')->user()->last_name }}
                                {{ auth('worker')->user()->second_last_name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('workers.dashboard')">
                            <i class="fa-solid fa-file-invoice"></i> {{ __('Ver mis boletas') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-200"></div>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('workers.logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('workers.logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                <i class="fa-solid fa-power-off"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endauth
            @auth('web')
                <x-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 my-2 py-2 border border-transparent text-md leading-4 rounded-md text-gray-100 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ auth('web')->user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('dashboard.index')">
                            <i class="fa-solid fa-desktop"></i> {{ __('Panel de administración') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-200"></div>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                <i class="fa-solid fa-power-off"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endauth
            @if(Auth::guard('web')->guest() && Auth::guard('worker')->guest())
                <a href="{{ route('workers.login') }}"
                    class="inline-block px-4 py-2 hover:bg-blue-950 transition-transform transform hover:scale-110 rounded m-0">
                    <i class="fa-solid fa-file-invoice"></i> CONSULTAR BOLETAS
                </a>
                <a href="{{ route('login') }}"
                    class="inline-block px-4 py-2 hover:bg-blue-950 transition-transform transform hover:scale-110 rounded m-0">
                    <i class="fa-solid fa-user-tie"></i> PANEL ADMINISTRACIÓN
                </a>
            @endif

        </ul>

    </nav>
    <main class="mb-auto">
        <nav class="sm:hidden relative px-2 py-2">
            <button data-ripple-light="true" data-collapse-target="collapse"
                class="select-none w-full rounded-md bg-gray-900 py-2 text-center align-middle font-sans uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div data-collapse="collapse"
                class="h-0 w-full basis-full overflow-hidden transition-all duration-300 ease-in-out">
                <div
                    class="relative mx-auto my-4 flex flex-col rounded-md bg-white bg-clip-border text-gray-700 shadow-md">
                    <div class="flex flex-col my-2">
                        @auth('worker')
                            <div class="px-4">
                                <div class="font-medium text-base mb-2 text-gray-800">
                                    {{ auth('worker')->user()->name }} {{ auth('worker')->user()->last_name }}
                                    {{ auth('worker')->user()->second_last_name }}
                                </div>
                            </div>
                            <div class="border-t border-gray-200"></div>
                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('workers.dashboard')">
                                    <i class="fa-solid fa-file-invoice"></i> {{ __('Ver mis boletas') }}
                                </x-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('workers.logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('workers.logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="fa-solid fa-power-off"></i> {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        @endauth
                        @auth('web')
                            <div class="px-4">
                                <div class="font-medium text-base mb-2 text-gray-800">
                                    {{ auth('web')->user()->name }}
                                </div>
                            </div>
                            <div class="border-t border-gray-200"></div>
                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('dashboard.index')">
                                    <i class="fa-solid fa-file-invoice"></i> {{ __('Panel administrativo') }}
                                </x-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="fa-solid fa-power-off"></i> {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        @endauth
                        @if(Auth::guard('web')->guest() && Auth::guard('worker')->guest())
                            <a href="{{ route('workers.login') }}"
                                class="inline-block px-4 py-2 hover:bg-blue-950 hover:text-white rounded m-0">
                                <i class="fa-solid fa-file-invoice"></i> CONSULTAR BOLETAS</a>
                            <a href="{{ route('login') }}"
                                class="inline-block px-4 py-2 hover:bg-blue-950 hover:text-white rounded m-0">
                                <i class="fa-solid fa-user-tie"></i> PANEL ADMINISTRACIÓN</a>
                        @endif

                    </div>
                </div>
            </div>
        </nav>

        @yield('content')

    </main>
    <footer class="bg-blue-950 py-4 text-white text-center text-sm">
        <p>© {{ date('Y') }}. Unidad de Gestión Educativa Local de Asunción.</p>
        <p>RUC: 20571440921 | Jr. Lima S/N (a tres cuadras de la Plaza de Armas)</p>
    </footer>
    <div class="fixed bottom-4 right-4 z-50">
        <input type="checkbox" id="btn-mas">
        <div class="redes">
            <a target="_blank"
                href="https://web.facebook.com/p/Unidad-de-Gesti%C3%B3n-Educativa-Local-de-Asunci%C3%B3n-61555301019437/?_rdc=1&_rdr#"
                class="fa-brands fa-facebook bg-blue-900 text-white"></a>
            <a target="_blank" href="https://www.youtube.com/@ugelasuncion8696"
                class="fa-brands fa-youtube bg-blue-900 text-white"></a>
            <a target="_blank" href="https://www.gob.pe/ugelasuncion"
                class="fa-solid fa-globe bg-blue-900 text-white"></a>
        </div>
        <div class="btn-mas">
            <label for="btn-mas" class="fa-solid fa-at bg-gray-600 text-white"></label>
        </div>
    </div>
    <!-- Livewire Scripts -->
    @livewireScripts
    <script src="{{ asset('js/welcome.js') }}"></script>
    @yield('js')
    @stack('scripts')
</body>

</html>
