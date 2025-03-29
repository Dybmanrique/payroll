<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transparencia UNASAM</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-950 flex flex-col h-screen justify-between">
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
            <a href="{{ route('login') }}"
                class="inline-block px-4 py-2 hover:bg-blue-950 transition-transform transform hover:scale-110 rounded m-0">
                <i class="fa-solid fa-file-invoice"></i> CONSULTAR BOLETAS
            </a>
            <a href="{{ route('login') }}"
                class="inline-block px-4 py-2 hover:bg-blue-950 transition-transform transform hover:scale-110 rounded m-0">
                <i class="fa-solid fa-user-tie"></i> PANEL ADMINISTRACIÓN
            </a>
        </ul>
    </nav>
    <main class="mb-auto">
        <nav class="sm:hidden relative px-2 py-2">
            <button data-ripple-light="true" data-collapse-target="collapse"
                class="select-none w-full rounded-md bg-gray-900 py-2 text-center align-middle font-sans uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                INGRESAR
            </button>
            <div data-collapse="collapse"
                class="h-0 w-full basis-full overflow-hidden transition-all duration-300 ease-in-out">
                <div class="relative mx-auto my-4 flex flex-col rounded-md bg-white bg-clip-border text-gray-700 shadow-md">
                    <div class="flex flex-col">
                        <a href="{{ route('login') }}" class="inline-block px-4 py-2 hover:bg-blue-950 hover:text-white rounded m-0">
                            <i class="fa-solid fa-file-invoice"></i> CONSULTAR BOLETAS</a>
                        <a href="{{ route('login') }}" class="inline-block px-4 py-2 hover:bg-blue-950 hover:text-white rounded m-0">
                            <i class="fa-solid fa-user-tie"></i> PANEL ADMINISTRACIÓN</a>
                    </div>
                </div>
            </div>
        </nav>

        <section class="hero">
            <img src="{{ asset('img/chacas.jpg') }}" alt="Campus Universitario" class="w-full object-cover block"
                style="min-height: 400px; max-height: 720px">
            {{-- <div class="w-full object-cover block" id="img-back">
                <div class="landscape"></div>
                <div class="glass"></div>
            </div> --}}
            {{-- <div class="hero-text p-5 lg:p-10">
                <h1 class="font-bold text-xl md:text-4xl">TRANSPARENCIA UNASAM</h1>
                <p class="uppercase text-sm md:text-xl">Una nueva Universidad para el Desarrollo</p>
            </div> --}}
        </section>
        <footer class="bg-blue-950 py-4 text-white text-center text-sm">
            <p>© {{date('Y')}}. Unidad de Gestión Educativa Local de Asunción.</p>
            <p>RUC: 20571440921 | Jr. Lima S/N (a tres cuadras de la Plaza de Armas)</p>
        </footer>
    </main>
    <div class="fixed bottom-4 right-4 z-50">
        <input type="checkbox" id="btn-mas">
        <div class="redes">
            <a target="_blank" href="https://web.facebook.com/p/Unidad-de-Gesti%C3%B3n-Educativa-Local-de-Asunci%C3%B3n-61555301019437/?_rdc=1&_rdr#"
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
    <script src="{{ asset('js/welcome.js') }}"></script>
    @stack('scripts')
</body>

</html>
