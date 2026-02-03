<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cookie-consent.js'])
</head>
<body>
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex flex-wrap items-center gap-4">
            <a class="text-3xl font-black" href="{{route('home')}}">DevStagram</a>

            <form action="{{ route('users.search') }}" method="GET" class="order-last w-full md:order-none md:flex-1">
                <label for="user-search" class="sr-only">Buscar usuarios</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 15.75 3.5 3.5m-6.5-3a6.5 6.5 0 1 1 0-13 6.5 6.5 0 0 1 0 13Z" />
                        </svg>
                    </span>
                    <input
                        type="search"
                        id="user-search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar usuarios..."
                        class="w-full border border-gray-200 rounded-lg py-2 pl-10 pr-4 text-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500"
                        minlength="2"
                    >
                </div>
            </form>

            @auth
                <nav class="flex gap-2 items-center ml-auto">
                    @if (auth()->user()->isAdmin())
                        <a class="font-bold text-sm text-indigo-600" href="{{ route('admin.users.index') }}">Administración</a>
                    @endif
                    <a class="flex items-center gap-2 bg-white border p-2 text-gary-600 rounded text-sm font-bold cursor-pointer"
                        href="{{route('posts.create')}}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                        Crear
                    </a>
                    <a class="font-bold text-gray-600 text-sm" 
                        href="{{route('posts.index', auth()->user()->username)}}">Hola <span class="font-normal justify-center">{{auth()->user()->name}}</span>
                    </a>

                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-600 text-sm">Cerrar sesión
                        </button>
                    </form>
                </nav>
            @endauth

            @guest
                <nav class="flex gap-2 items-center ml-auto">
                    <a class="font-bold uppercase text-gray-600 text-sm" 
                    href="{{route('login')}}">Login</a>
                    <a class="font-bold uppercase text-gray-600 text-sm" 
                        href="{{route('register')}}" >Crear cuenta
                    </a>
                </nav>
            @endguest
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="font-black text-center text-3xl mb-10">
            @yield('titulo')
        </h2>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @yield('contenido')
    </main>

    <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
        DevStagram - Todos los derechos reservados {{now()->year}}
    </footer>

    <div id="cookie-consent" class="hidden fixed inset-x-0 bottom-0 z-50 p-4">
        <div class="mx-auto max-w-4xl bg-white border border-gray-200 rounded-xl shadow-2xl p-6 flex flex-col gap-3 text-gray-700">
            <p class="text-base leading-relaxed">
                Utilizamos cookies técnicas obligatorias para garantizar el funcionamiento de DevStagram y la seguridad de tu sesión. Estas cookies no recaban datos personales con fines comerciales, pero la normativa exige tu aceptación expresa antes de seguir navegando.
            </p>
            <div class="flex flex-wrap gap-3 items-center justify-end">
                <button id="cookie-accept" type="button" class="bg-gray-900 text-white px-5 py-2 rounded-lg text-sm font-bold uppercase tracking-wide">
                    Aceptar cookies obligatorias
                </button>
            </div>
        </div>
    </div>

</body>
</html>