@extends('layouts.app')

@section('titulo')
    Buscar usuarios
@endsection

@section('contenido')
    <div class="max-w-3xl mx-auto space-y-6">
        <p class="text-gray-600 text-sm">
            Escribe al menos dos caracteres para localizar usuarios por nombre o nombre de usuario. Los resultados se actualizan al enviar el formulario.
        </p>

        @php
            $hasQuery = mb_strlen($query) >= 2;
        @endphp

        @if (! $hasQuery)
            <p class="text-gray-500 text-sm">Empieza una búsqueda desde la barra superior.</p>
        @elseif ($users && $users->count())
            <div class="bg-white border border-gray-200 rounded-xl divide-y">
                @foreach ($users as $user)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ '@' . $user->username }}</p>
                        </div>
                        <a href="{{ route('posts.index', $user->username) }}" class="text-sm font-bold text-gray-900">Ver perfil</a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @else
            <p class="text-gray-500 text-sm">No encontramos usuarios que coincidan con "{{ $query }}".</p>
        @endif
    </div>
@endsection
