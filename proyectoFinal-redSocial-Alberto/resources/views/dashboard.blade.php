@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <!--
                    Mediante operador ternario manejamos el cambio de la imagen principal del perfil de usuario.
                    En caso de que esta no exista, mostramos la imagen por defecto. 
                -->
                <img src="{{ $user->imagen ? asset('storage/perfiles/' . $user->imagen) : asset('img/img_usuario.avif') }}" alt="Imagen usuario">
            </div>

            <div class="md:w-8/12 lg:w-6/12 px-5 flex md:justify-center flex-col items-center py-10 md:items-start md:py-10">
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a href="{{ route('perfil.index', ['user' => $user->username]) }}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{$user->followers->count()}}
                    <!--La directiva choice lo que hace es modificar el texto dependiendo del número de seguidores-->
                    <span class="font-normal">@choice('Seguidor|Seguidores', $user->followers->count())</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->following->count()}}
                    <span class="font-normal">Siguiendo</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->posts->count() }}
                    <span class="font-normal">Post</span>
                </p>
                @auth
                    <!--Evitamos que te puedas seguir a ti mismo-->
                    @if ($user->id !== auth()->user()->id)
                        @if (!$user->siguiendo(auth()->user()))
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit" class="bg-blue-600 text-white rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" value="Seguir">
                            </form>
                        @else
                            <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="bg-red-600 text-white rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" value="Dejar de seguir">
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

        @if ($posts->count()) 
        <!--
            Es un foreach que accede a la variable posts que le pasamos desde el controlador PostController.php
        -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['user' => $user, 'post' => $post]) }}">
                        <img src="{{ asset('storage/uploads/' . '/' . $post->imagen)}}" alt="Imagen del post de {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="my-10">
            <!--De esta forma laravel ya pagina tus registros de manera automática-->
            {{ $posts->links('pagination::tailwind') }}
        </div>
        
        @else
            <p class="text-gray-600 uppercase text-sm text-center font-bold">No hay publicaciones aún.</p>
        @endif
    </section>
@endsection