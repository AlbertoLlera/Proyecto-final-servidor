@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto flex flex-col lg:flex-row gap-10 px-6">
        <div class="md:w-1/2 lg:w-5/12 mx-auto lg:mx-0 space-y-4">
            <img class="rounded-lg shadow-lg w-full max-w-xl mx-auto lg:mx-0 object-cover max-h-[28rem]" src="{{ asset('storage/uploads/' . $post->imagen) }}" alt="Imagen del post {{ $post->titulo }}">
            <div class="p-3 text-center">
                <p>0 likes</p>
            </div>
            <div class="bg-white rounded-lg p-5 shadow">
                @if ($post->user)
                    <p class="font-bold">{{ $post->user->username }}</p>
                @else
                    <p class="font-bold text-gray-500">Usuario no disponible</p>
                @endif
                <!--
                    Con diffForHumans mostramos el tiempo que ha pasado desde que se creó el post.
                    Esta es una libreria que viene por defecto en Laravel. 
                -->
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                <p class="mt-5">{{ $post->descripcion }}</p>
            </div>
            <!--Revisamos que el usuario este utenticado y que sea el dueño del post para poder mostrar el botón de eliminar-->
            @auth
                @if ($post->user_id === auth()->user()->id)
                <form class="bg-white rounded-lg p-5 shadow" action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    <!--
                        DELETE no existe como tal en los métodos, por eso es necesario indicarlo con method.
                        Es lo que se conoce como methos spoofing, ya que los formularios solo soportan GET y POST.
                    -->
                    @method('DELETE')
                    <input 
                        type="submit"
                        value="Eliminar publicación"
                        class="bg-red-500 hover:bg-red-600 p-3 rounded text-white font-bold mt-4 cursor-pointer w-full text-center"
                    >
                </form>
                @endif
            @endauth

        </div>

        <div class="md:w-1/2 lg:w-7/12 p-5">
            <div class="shadow bg-white p-5 mb-5">
                <!--
                    Rodeamos el parrafo y el formulario con if, que es un helper.
                    De esta manera, solo los usuarios autenticados pueden ver el formulario y comentar en él.
                -->
                @if(auth()->check())
                    <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>

                    @if (session('mensaje'))
                        <p class="bg-green-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ session('mensaje') }}
                        </p>
                    @endif

                    <form action="{{route('comentarios.store', ['user' => $user, 'post' => $post])}}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb block uppercase text-gray-500 font-bold">
                                Añade un comentario
                            </label>

                            <textarea
                                id="comentario"
                                name="comentario"
                                placeholder="Agrega un comentario"
                                class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror">
                            </textarea>

                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <input type="submit"
                            value="Comentar"
                            class="bg-sky-600 hover:bg-sky-700 transition-color cursor-pointer 
                                    uppercase font-bold w-full p-3 text-white rounded-lg">
                    </form>
                @endif

                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-5">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <!--Redirecionando al usuario que comentó gracias al enrutado de Laravel-->
                                <a href="{{route('posts.index', $comentario->user)}}" class="font-bold">
                                    {{ $comentario->user->username ?? 'Usuario no disponible' }}
                                </a>
                                <p>{{ $comentario->comentario }}</p>
                                <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No hay comentarios por el momento</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
        
    

@endsection