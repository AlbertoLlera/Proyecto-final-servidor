@extends('layouts.app')

@section('titulo')
    
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
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
        <p>No hay posts</p>
    @endif

@endsection